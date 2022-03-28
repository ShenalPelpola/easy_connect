<?php

/**
 * Contacts page controller - This controller handles rendering views.
 */
class Contacts extends CI_Controller
{
    /**
     * This method renders the contact list page.
     */
    public function index()
    {
        $this->load->view('contact/contactList');
    }

    /**
     * This method renders the contact details page.
     */
    public function details()
    {
        $contact_id = $this->input->get('contact_id', TRUE);

        // if the contact id is empty redict to the contact list view.
        if (!$contact_id) {
            redirect("/Contacts");
        }
        $data['contact_id'] = $contact_id;
        $this->load->view('contact/contactDetails', $data);
    }

    /**
     * This method renders the favorite list page.
     */
    public function favorites()
    {
        $this->load->view('contact/favoriteContacts');
    }

    /**
     * This method renders the recent contacts page.
     */
    public function recent()
    {
        $this->load->view('contact/recentContacts');
    }
}
