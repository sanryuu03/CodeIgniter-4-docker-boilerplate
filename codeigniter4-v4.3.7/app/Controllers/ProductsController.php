<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductsModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class ProductsController extends ResourceController
{
  use ResponseTrait;

  public function index()
  {
    $model = new ProductsModel();
    $data = $model->findAll();
    return $this->respond($data);
  }

  public function show($id = null)
  {
    $model = new ProductsModel();
    $data = $model->find($id);
    if (!$data) {
      return $this->failNotFound('No Data Found');
    };
    return $this->respond($data);
  }

  /**
   * Return a new resource object, with default properties
   *
   * @return mixed
   */
  public function new()
  {
    //
  }

  public function create()
  {
    $model = new ProductsModel();

    try {
      helper(['form']);
      $rules = [
        'title' => 'required|string|min_length[3]',
        'price' => 'required|numeric|integer|is_natural|min_length[3]'
      ];

      $data = [
        'title' => $this->request->getVar('title'),
        'price' => $this->request->getVar('price')
      ];

      $model->transException(true)->transStart();
      if (!$this->validate($rules)) {
        return $this->fail($this->validator->getErrors());
      }
      $model->save($data);
      $response = [
        'status' => 201,
        'error' => false,
        'message' => 'success',
        'berisi' => 'Data Inserted',
      ];
      $model->transComplete();
      return $this->respondCreated($response);
    } catch (DatabaseException $e) {
      $response = [
        'status' => 500,
        'error' => true,
        'message' => $e,
        'berisi' => 'kosong',
      ];
      return $this->respondCreated($response);
    }
  }

  /**
   * Return the editable properties of a resource object
   *
   * @return mixed
   */
  public function edit($id = null)
  {
    //
  }

  public function update($id = null)
  {
    $model = new ProductsModel();

    try {
      helper(['form']);
      $rules = [
        'title' => 'required|string|min_length[3]',
        'price' => 'required|numeric|integer|is_natural|min_length[3]'
      ];

      $data = [
        'title' => $this->request->getVar('title'),
        'price' => $this->request->getVar('price')
      ];

      $model->transException(true)->transStart();
      if (!$this->validate($rules)) {
        return $this->fail($this->validator->getErrors());
      }

      $dataId = $model->find($id);
      if (!$dataId) {
        return $this->failNotFound('No Data Found');
      };

      $model->update($id, $data);
      $response = [
        'status' => 200,
        'error' => false,
        'message' => 'success',
        'berisi' => 'Data Updated',
      ];
      $model->transComplete();
      return $this->respond($response);
    } catch (DatabaseException $e) {
      $response = [
        'status' => 500,
        'error' => true,
        'message' => $e,
        'berisi' => 'kosong',
      ];
      return $this->respondCreated($response);
    }
  }

  public function delete($id = null)
  {
    $model = new ProductsModel();

    try {
      $model->transException(true)->transStart();
      $dataId = $model->find($id);
      if (!$dataId) {
        return $this->failNotFound('No Data Found');
      };

      $model->delete($id);
      $response = [
        'status' => 200,
        'error' => false,
        'message' => 'success',
        'berisi' => 'Data Deleted',
      ];
      $model->transComplete();
      return $this->respond($response);
    } catch (DatabaseException $e) {
      $response = [
        'status' => 500,
        'error' => true,
        'message' => $e,
        'berisi' => 'kosong',
      ];
      return $this->respondCreated($response);
    }
  }
}
