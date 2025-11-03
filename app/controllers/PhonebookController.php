<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/**
 * phonebook class
 */

class PhonebookController
{
    use Controller;
    public function index()
    {   

        if(!isset($_SESSION['user_id'])) {
            header('Location: ' . ROOT . '/login');
            exit;
        }

        $phonebookModel = $this->model('Phonebook');
        $user_id = $_SESSION['user_id'];
        $contacts = $phonebookModel->getAllByUser($user_id);

        $data = [
            'username' => $_SESSION['username'],
            'contacts' => $contacts
        ];
   
        $this->view('phonebook', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $name = trim($_POST['name']);
            $phonenumber = trim($_POST['phone']);

            if(!empty($name) && !empty($phonenumber)) {
                $phonebookModel = $this->model('Phonebook');
                $phonebookModel->add($user_id, $name, $phonenumber);
                $_SESSION['success'] = "Contact added successfully!";
            } else {
                $_SESSION['error'] = "Name and phone are required.";
            }
                header('Location: ' . ROOT . '/phonebook');
                exit;
        }
            $this->view('add_contact');
    }

    public function delete($id)
    {
        $phonebookModel = $this->model('Phonebook');
        $phonebookModel->delete($id);
         header('Location: ' . ROOT . '/phonebook');
        exit;
    }
    
    public function edit($id)
    {
        $phonebookModel = $this->model('Phonebook');

        // Get existing contact info by ID
        $contact = $phonebookModel->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Get updated data from form
            $name = $_POST['name'];
            $phonenumber = $_POST['phonenumber'];

            // Update in the database
            $phonebookModel->update($id, $name, $phonenumber);
            
            $_SESSION['success'] = "Updated successfully!";
            //Redirect back to phonebook list
            header('Location: ' . ROOT . '/phonebook');
            exit;
        }
        // Show the edit form
        $this->view('edit_contact', ['contact' => $contact]);
    }
}
