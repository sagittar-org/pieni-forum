<?php
class Post extends Crud {

	public function reply()
	{
		if ($_POST === [])
		{
			$this->model->view(uri('id'));
			if ($this->model->row === NULL)
			{
				show_404();
			}
			exit(json_encode($this->model->row));
		}
		$this->model->add($_POST);
		if ($this->model->result === TRUE)
		{
			flash(l('crud_add_succeeded', [], TRUE), 'success');
		}
		else
		{
			flash(l('crud_add_failed', [], TRUE), 'warning');
		}
		$this->post_add();
	}
}
