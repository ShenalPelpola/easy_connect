<?php

class Contact_model extends CI_Model
{
    private $entity = 'contact';

    /**
     * This method retrives all the contacts.
     * @return      Array   An array of contacts.
     */
    public function get_contacts()
    {
        $sql = "SELECT *
        FROM $this->entity 
        ORDER BY first_name ASC;";

        $query = $this->db->query($sql);
        if (!$query) {
            return [];
        }
        $contacts = $query->result();

        // for every contact get the related tags and add to contacts array.
        foreach ($contacts as $contact) {
            $tags = $this->get_tags($contact->id);
            $contact->tags = $tags;
        }
        return $contacts;
    }

    /**
     * This method retrives a contact by its id.
     *
     * @param       int     $contactId - contact id
     * @return      Object  An aaray of contacts.
     */
    public function get_contact_by_id($contactId)
    {
        $contact = $this->db->get_where($this->entity, [
            'id' => $contactId,
        ])->row();

        // if the contact not found return null
        if ($contact == null) {
            return null;
        }

        $contact->tags = $this->get_tags($contact->id);
        return $contact;
    }

    /**
     * This method retrives all the favorited contacts.
     * @return      Array   An array of favorite contacts.
     */
    public function get_favorite_contacts()
    {
        $sql = "SELECT *
        FROM $this->entity 
        WHERE contact.favorite = true;";

        $query = $this->db->query($sql);
        if (!$query) {
            return [];
        }
        $contacts = $query->result();

        // for every contact get the related tags and add to contacts array.
        foreach ($contacts as $contact) {
            $tags = $this->get_tags($contact->id);
            $contact->tags = $tags;
        }
        return $contacts;
    }

    /**
     * This method retrives all the recent contacts (contacts created within 7 days).
     * @return      Array   An array of recent contacts.
     */
    public function get_recent_contacts()
    {
        $recentDate = date("Y-m-d H:i:s", strtotime('-7 day', strtotime(date("Y-m-d H:i:s"))));
        $sql = "SELECT *
        FROM $this->entity 
        WHERE contact.created_date >= '$recentDate';";

        $query = $this->db->query($sql);
        if (!$query) {
            return [];
        }
        $contacts = $query->result();

        // for every contact get the related tags and add to contacts array.
        foreach ($contacts as $contact) {
            $tags = $this->get_tags($contact->id);
            $contact->tags = $tags;
        }
        return $contacts;
    }

    /**
     * Insert newly created contact data to the contact table.
     *
     * @param       Array  $data - A array containing contact details.
     * @return      Object  The new created contact
     */
    public function create($data)
    {
        if (!isset($data)) {
            return null;
        }
        // store tags in a variable before deleting it from the array.
        $tags = $data["tags"];
        // remove the tags before inserting contacts details to contact table. 
        $data = $this->extract_tags($data, "tags");

        if (!$this->contactExits($data['email'], $data['telephone'])) {
            // if succesfully inserted retrive the contact from the table
            $this->db->trans_start();
            if ($this->db->insert($this->entity, $data)) {

                $contact = $this->db->get_where($this->entity, [
                    'email' => $data["email"],
                ])->row();

                // insert data into contact_tag table
                if ($tags != null) {
                    foreach ($tags as $tag) {;
                        $this->db->insert('contact_tag', ["tag_id" => $tag, "contact_id" => $contact->id]);
                    }
                }
            }

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                return null;
            }

            // get contact tags after inserting the contact.
            $tags = $this->get_tags($contact->id);
            $contact->tags = $tags;
            return $contact;
        }
        return null;
    }

    /**
     * Delete contact data from the contact table.
     *
     * @param       int   $contactId - Id of the contact.
     * @return      bool  bool value based on the deletion.
     */
    public function delete($contactId)
    {
        $contact = $this->db->get_where($this->entity, [
            'id' => $contactId,
        ])->row();

        // if the contact not found return false
        if ($contact == null) {
            return false;
        }

        $this->db->delete($this->entity, ['id' => $contactId]);
        $error = $this->db->error();
        if (!empty($error['code'])) {
            return false;
        }
        return true;
    }

    /**
     * Update contact data int the contact table.
     *
     * @param       int    $contactId - Id of the contact.
     * @param       Array  $data - new detail of the contact.
     * @return      bool   bool value based on the deletion.
     */
    public function update($contactId, $data)
    {
        // Remove the tags before updating contacts details to contact table. 
        $tags = $data["tags"];
        $telephone = $data["telephone"];
        $email = $data["email"];

        $data = $this->extract_tags($data, "tags");

        $this->db->trans_start();

        $exists = $this->get_contact_by_id($contactId);

        if (!$exists) {
            return false;
        }

        // checck if entered email and telephone number is already taken by a different contact id.
        $sql = "SELECT * from $this->entity WHERE (telephone='$telephone' OR email='$email') AND id != $contactId;";
        if ($this->db->query($sql)->result() != null) {
            return false;
        }

        $updated = $this->db->update($this->entity, $data, ['id' => $contactId]);
        if (!$updated) {
            return false;
        }

        if (count($tags) != 0 || $tags == null) {
            // delete the previous tags of the contact before updating
            $this->db->delete('contact_tag', ["contact_id" => $contactId]);
            // update(insert) the new tags for the contact.
            foreach ($tags as $tag) {
                $this->db->where(['tag_id' => $tag, 'contact_id' => $contactId]);
                $this->db->insert('contact_tag', ["tag_id" => $tag, "contact_id" => $contactId]);
            }
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return false;
        }

        return true;
    }

    /**
     * Search contacts based on search conditions.
     *
     * @param       Array  $data - search criterias
     * @return      Array  contacts array where the search condition matches.
     */
    public function search($data)
    {
        $searchContacts = [];
        $first_name = $data["first_name"];
        $last_name = $data["last_name"];
        $email = $data["email"];
        $telephone = $data["telephone"];
        $address = $data['address'];
        $startDate = $data["startDate"];
        $endDate = $data["endDate"];
        $searchTags = $data["tags"];

        $sql = "SELECT * FROM $this->entity 
        WHERE ";

        $flag = 0;

        // construct search query
        if ($first_name != null) {
            $sql .= "first_name='$first_name' ";
            $flag = 1;
        }

        if ($last_name != null) {
            if ($flag == 1) $sql .= " AND ";
            $sql .= " last_name='$last_name' ";
            $flag = 1;
        }

        if ($email != null) {
            if ($flag == 1) $sql .= " AND ";
            $sql .= " email='$email' ";
            $flag = 1;
        }

        if ($telephone != null) {
            if ($flag == 1) $sql .= " AND ";
            $sql .= " telephone='$telephone' ";
            $flag = 1;
        }

        if ($address != null) {
            if ($flag == 1) $sql .= " AND ";
            $sql .= " address='$address' ";
            $flag = 1;
        }

        if ($startDate != null && $endDate != null) {
            if ($flag == 1) $sql .= " AND ";
            $sql .= " created_date >= '$startDate' AND created_date <= '$endDate'";
            $flag = 1;
        }

        $query = $this->db->query($sql);
        if (!$query) {
            return [];
        }
        $contacts = $query->result();

        if ($data["tags"] != null) {
            foreach ($contacts as $contact) {
                $tags = $this->get_tags($contact->id);
                $found = $this->searchTagsFound($tags, $searchTags);

                if ($found) {
                    $contact->tags = $tags;
                    array_push($searchContacts, $contact);
                }
            }
            return $searchContacts;
        }
        foreach ($contacts as $contact) {
            $tags = $this->get_tags($contact->id);
            $contact->tags = $tags;
        }
        return $contacts;
    }

    /**
     * Search contacts based on search conditions.
     *
     * @param       Array  $searchTags - search tags.
     * @return      Array  contacts array where the search tags matches.
     */
    public function tagSearch($searchTags)
    {
        $searchContacts = [];
        $sql = "SELECT *
        FROM $this->entity;";

        $query = $this->db->query($sql);
        if (!$query) {
            return [];
        }
        $contacts = $query->result();
        foreach ($contacts as $contact) {
            $tags = $this->get_tags($contact->id);
            $found = $this->searchTagsFound($tags, $searchTags);
            if ($found) {
                $contact->tags = $tags;
                array_push($searchContacts, $contact);
            }
        }
        return $searchContacts;
    }

    // Helper functions //

    /**
     * The is a private function to check if searchtags are in contact tags.
     *
     * @param       Array   $tags - tags of the contact.
     * @param       Array   $searchTags - tags in the search condition.
     * @return      Object  A array of tags.
     */
    private function searchTagsFound($tags, $searchTags)
    {
        $found = false;
        foreach ($tags as $tag) {
            if (in_array($tag->tag_id, $searchTags)) {
                $found = true;
            }
        }
        return $found;
    }

    /**
     * The is a private function to get all the tags of a contact.
     *
     * @param       int   $contactId - id of the contact.
     * @return      Object  A array of tags.
     */
    private function get_tags($contactId)
    {
        $sql = "SELECT ct.tag_id, tg.category_name
        FROM contact_tag AS ct
        INNER JOIN 
            tag AS tg ON ct.tag_id = tg.id 
        WHERE ct.contact_id = $contactId;";

        $query = $this->db->query($sql);
        if (!$query) {
            return [];
        }
        return $query->result();
    }

    /**
     * Checks whether the contact exists in the contacts table. 
     *
     * @param       string  $email - email of the contact record
     * @param       string  $telephone - telephone of the contact record.
     * @return      bool    $exists - A boolean value based on contact's existance
     */
    private function contactExits($email, $telephone)
    {
        $sql = "SELECT * from $this->entity WHERE (telephone='$telephone' OR email='$email')";

        if ($this->db->query($sql)->result() == null) {
            return false;
        }
        return true;
    }

    /**
     * Checks whether the contact exists in the contacts table. 
     *
     * @param       string  $email - email of the contact record
     * @param       string  $telephone - telephone of the contact record.
     * @return      bool    $exists - A boolean value based on contact's existance
     */
    private function extract_tags($data, $key)
    {
        if (array_key_exists($key, $data)) {
            unset($data[$key]);
            return $data;
        }
        return [];
    }
}
