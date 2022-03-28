<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Contacts extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Contact_model');
    }

    /**
     * This method retrives all the contacts.
     * @return      JSONArray     An array of fetched contacts.
     */
    public function index_get()
    {
        $contacts = $this->Contact_model->get_contacts();

        log_message('info', "Endpoint: index_get() - Returned a list of contacts.");
        $this->set_response($contacts, REST_Controller::HTTP_OK);
    }

    /**
     * This method retrives a contact by it's id.
     * @param       QueryParam    $contactId - Id of the contact.
     * @return      JSONObject    Details of the contact.
     */
    public function contact_get()
    {
        $contact_id = (int) $this->get('contact_id');

        // check wheather the provided id is valid.
        if ($contact_id <= 0) {
            log_message('error', "Endpoint: contact_get() - Provided contact_id is invalid.");

            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        // call to the model to retrive the contact.
        $contact = $this->Contact_model->get_contact_by_id($contact_id);

        // check id the contact exists.
        if ($contact == null) {
            log_message('error', "Endpoint: contact_get() - Contact with the id {$contact_id} doesn't exists.");
            $this->response(NULL, REST_Controller::HTTP_NOT_FOUND);
            return;
        }

        log_message('info', "Endpoint: contact_get() - Returned a details of the contact for id {$contact_id}");
        $this->set_response($contact, REST_Controller::HTTP_OK);
    }

    /**
     * This method creats a new contact.
     * @param       RequestBody   Details of the newly created contact.
     * @return      JSONObject    Details of the newly created contact.
     */
    public function index_post()
    {
        // Retrive posted contact details.
        $data = [
            "email" => $this->post('email', TRUE),
            "telephone" => $this->post('telephone', TRUE),
            "first_name" => $this->post("first_name", TRUE),
            "last_name" => $this->post("last_name", TRUE),
            "address" => $this->post("address", TRUE),
            "tags" => $this->post("tags", TRUE),
            "notes" => $this->post("notes", TRUE),
            "created_date" => date("Y-m-d H:i:s"),
            "avatar" => $this->post("avatar", TRUE),
            "favorite" => false
        ];

        // validate if email and telephone are preesnt in the request body.
        if ($data["email"] == "" || $data["telephone"] == "") {
            log_message('error', "Endpoint: index_post() - Invalid request format.");
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $created = $this->Contact_model->create($data);

        // check if the contact was created.
        if ($created == null) {
            log_message('error', "Endpoint: index_post() - Error when creating a new contact.");
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
        // Return created contact info with code(201).
        log_message('info', "Endpoint: index_post() - Returned details of the newly created contact.");
        $this->set_response($created, REST_Controller::HTTP_CREATED);
    }

    /**
     * This method deletes a contact by its id.
     * @param       RequestBody   Id of the contact.
     * @return      JSONObject    Delete response.
     */
    public function contact_delete($id)
    {
        // Validate the id.
        if ($id <= 0) {
            log_message('error', "Endpoint: contact_delete() - Provided contact_id {$id} is invalid.");
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $deleted = $this->Contact_model->delete($id);

        // check if the contact was deleted.
        if (!$deleted) {
            log_message('error', "Endpoint: contact_delete() - Contact with the id {$id} doesn't exists.");
            $this->response(NULL, REST_Controller::HTTP_NOT_FOUND);
            return;
        }

        // return delete response.
        $res = [
            'id' => $id,
            'message' => 'Deleted the contact',
        ];

        $this->set_response($res, REST_Controller::HTTP_OK);
    }

    /**
     * This method updates the contact.
     * @param       RequestBody   Id of the contact + Update details of the contact..
     * @return      JSONObject    update response.
     */
    public function contact_put()
    {
        $id = (int) $this->put('id');
        $data = [
            "email" => $this->put('email', TRUE),
            "telephone" => $this->put('telephone', TRUE),
            "first_name" => $this->put("first_name", TRUE),
            "last_name" => $this->put("last_name", TRUE),
            "favorite" => $this->put("favorite", TRUE),
            "address" => $this->put("address", TRUE),
            "tags" => $this->put("tags", TRUE),
            "notes" => $this->put("notes", TRUE),
            "avatar" => $this->put("avatar", TRUE),
        ];

        // validate if id, email and telephone values are null
        if ($id <= 0 || $data["email"] == "" || $data["telephone"] == "") {
            log_message('error', "Endpoint: contact_put() - Invalid request format.");
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $updated = $this->Contact_model->update($id, $data);

        // check if the contact was successfully updated.
        if (!$updated) {
            log_message('error', "Endpoint: contact_put() - Contact with the id {$id} doesn't exists.");
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        // return update response.
        $res = [
            'id' => $id,
            'message' => 'updated the contact',
        ];
        log_message('info', "Endpoint: contact_put() - Contact with the id {$id} was updated.");
        $this->set_response($res, REST_Controller::HTTP_OK);
    }

    /**
     * This method retrives all the favorited contacts.
     * @return      JSONArray     An array of favorited contacts.
     */
    public function favorites_get()
    {
        $contacts = $this->Contact_model->get_favorite_contacts();

        log_message('info', "Endpoint: favorites_get() - Returned a list of favorite contacts");
        $this->set_response($contacts, REST_Controller::HTTP_OK);
    }

    /**
     * This method retrives all the recent(within 7 days) contacts.
     * @return      JSONArray     An array of recent contacts.
     */
    public function recent_get()
    {
        $contacts = $this->Contact_model->get_recent_contacts();

        log_message('info', "Endpoint: recent_get() - Returned a list of recent contacts");
        $this->set_response($contacts, REST_Controller::HTTP_OK);
    }

    /**
     * This method retrives all the contacts based of the search parameters.
     * @param       RequestBody   Search parameters.
     * @return      JSONArray     An array of contacts.
     */
    public function search_post()
    {
        $data = [
            "first_name" => $this->post("first_name", TRUE),
            "last_name" => $this->post("last_name", TRUE),
            "email" => $this->post("email", TRUE),
            "telephone" => $this->post("telephone", TRUE),
            "address" => $this->post("address", TRUE),
            "tags" => $this->post("tags", TRUE),
            "startDate" => $this->post("startDate", TRUE),
            "endDate" => $this->post("endDate", TRUE)
        ];
        $noResult = [];

        // check whether the search parameters are null
        if (
            $data["first_name"] == null && $data["last_name"] == null && $data["email"] == null
            && $data["telephone"] == null && $data["address"] == null && $data["tags"] == null
            && $data["startDate"] == null && $data["endDate"] == null
        ) {
            log_message('error', "Endpoint: search_post() - Invalid request format.");
            $this->response($noResult, REST_Controller::HTTP_OK);
            return true;
        }

        // check whether the search parameters are null expend the tags.
        if (
            $data["first_name"] == null && $data["last_name"] == null && $data["email"] == null
            && $data["telephone"] == null && $data["address"] == null
            && $data["startDate"] == null && $data["endDate"] == null && $data["tags"] != null
        ) {
            // search contacts based on only the tags.
            $searched = $this->Contact_model->tagSearch($data["tags"]);
            $this->response($searched, REST_Controller::HTTP_OK);
            return true;
        }

        // search contacts based on all parameters.
        $searched = $this->Contact_model->search($data);
        $this->set_response($searched, REST_Controller::HTTP_OK);
    }
}
