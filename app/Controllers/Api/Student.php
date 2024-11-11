<?php
// app/Controllers/Api/Student.php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\StudentModel;

class Student extends ResourceController
{
    protected $model;

    public function __construct()
    {
        $this->model = new StudentModel();
    }

    // CREATE - POST
    public function create()
    {
        $rules = [
            'student_id' => 'required|is_unique[students.student_id]|min_length[3]',
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[students.email]',
            'phone' => 'permit_empty|min_length[10]',
            'branch' => 'permit_empty|min_length[2]',
            'faculty' => 'permit_empty|min_length[2]'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $data = [
            'student_id' => $this->request->getVar('student_id'),
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'phone' => $this->request->getVar('phone'),
            'branch' => $this->request->getVar('branch'),
            'faculty' => $this->request->getVar('faculty')
        ];

        try {
            $this->model->insert($data);
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'Student created successfully'
                ]
            ];
            return $this->respondCreated($response);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    // READ ALL - GET 
    public function index()
    {
        $data = $this->model->findAll();
        return $this->respond($data);
    }

    // READ ONE - GET
    public function show($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond($data);
        }
        return $this->failNotFound('No student found with id ' . $id);
    }

    // UPDATE - PUT
    public function update($id = null)
    {
        // Check if ID exists
        $foundStudent = $this->model->find($id);
        if (!$foundStudent) {
            return $this->failNotFound('No student found with id ' . $id);
        }

        // Get the data
        $data = [
            'student_id' => $this->request->getVar('student_id'),
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'phone' => $this->request->getVar('phone'),
            'branch' => $this->request->getVar('branch'),
            'faculty' => $this->request->getVar('faculty')
        ];

        // Validation rules
        $rules = [
            'student_id' => 'required|min_length[3]|is_unique[students.student_id,id,'.$id.']',
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[students.email,id,'.$id.']',
            'phone' => 'permit_empty|min_length[10]',
            'branch' => 'permit_empty|min_length[2]',
            'faculty' => 'permit_empty|min_length[2]'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        try {
            $this->model->update($id, $data);
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Student data updated successfully'
                ]
            ];
            return $this->respond($response);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    // DELETE - DELETE
    public function delete($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            $this->model->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Student successfully deleted'
                ]
            ];
            return $this->respondDeleted($response);
        }
        return $this->failNotFound('No student found with id ' . $id);
    }
}