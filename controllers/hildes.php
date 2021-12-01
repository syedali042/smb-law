<?php

class CL_HILDES
{
	public function __construct()
	{
		$this->model = new MD_MAINMODEL();
		$this->temp = new LB_TEMPLATE('header', 'footer');
	}

	public function index()
	{
		$this->temp->loadcontent('index');
		$data['getUsers'] = $this->model->getUsers();
		$this->temp->loadview($data);
	}
	public function about()
	{
		$this->temp->loadcontent('about');
		$data['getUsers'] = $this->model->getUsers();
		$this->temp->loadview($data);
	}
	public function blogDetail()
	{
		$this->temp->loadcontent('blog-detail');
		$data['getUsers'] = $this->model->getUsers();
		$this->temp->loadview($data);
	}
	public function blog()
	{
		$this->temp->loadcontent('blog');
		$data['getUsers'] = $this->model->getUsers();
		$this->temp->loadview($data);
	}
	public function caseDetails()
	{
		$this->temp->loadcontent('case-details');
		$data['getUsers'] = $this->model->getUsers();
		$this->temp->loadview($data);
	}
	public function case()
	{
		$this->temp->loadcontent('case');
		$data['getUsers'] = $this->model->getUsers();
		$this->temp->loadview($data);
	}
	public function contact()
	{
		$this->temp->loadcontent('contact');
		$data['getUsers'] = $this->model->getUsers();
		$this->temp->loadview($data);
	}
	public function corporateLaw()
	{
		$this->temp->loadcontent('corporate_law');
		$data['getUsers'] = $this->model->getUsers();
		$this->temp->loadview($data);
	}
	public function familyLaw()
	{
		$this->temp->loadcontent('family_law');
		$data['getUsers'] = $this->model->getUsers();
		$this->temp->loadview($data);
	}
	public function insuranceLaw()
	{
		$this->temp->loadcontent('insurance_law');
		$data['getUsers'] = $this->model->getUsers();
		$this->temp->loadview($data);
	}
	public function ourTeam()
	{
		$this->temp->loadcontent('our_team');
		$data['getUsers'] = $this->model->getUsers();
		$this->temp->loadview($data);
	}
	public function realEstateLaw()
	{
		$this->temp->loadcontent('real_estate_law');
		$data['getUsers'] = $this->model->getUsers();
		$this->temp->loadview($data);
	}
	public function servicesStyle()
	{
		$this->temp->loadcontent('services_style');
		$data['getUsers'] = $this->model->getUsers();
		$this->temp->loadview($data);
	}


	
}