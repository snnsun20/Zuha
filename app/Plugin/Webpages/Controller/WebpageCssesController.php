<?php
/**
 * WebpagesCsses Controller
 *
 * Used to set variables used in the view files for the webpage css plugin. 
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.webpages.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
class WebpageCssesController extends WebpagesAppController {

	public $name = 'WebpageCsses';
	public $uses = 'Webpages.WebpageCss';

	function index() {
		$this->WebpageCss->recursive = 0;
		$this->set('webpageCsses', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid webpage css', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('webpageCss', $this->WebpageCss->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->WebpageCss->create();
			if ($this->WebpageCss->add($this->request->data, $this->theme)) {
				header("Pragma: no-cache"); 
				$this->Session->setFlash(__('The webpage css has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The webpage css could not be saved. Please, try again.', true));
			}
		}
		$types = $this->WebpageCss->types();
		$webpages = $this->WebpageCss->Webpage->find('list', array('conditions' => array('Webpage.type' => 'template')));
		$this->set(compact('types', 'webpages'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid webpage css', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->WebpageCss->update($this->request->data, $this->theme)) {
				$this->Session->setFlash(__('The webpage css has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The webpage css could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->WebpageCss->read(null, $id);			
			$cssFileContents = $this->WebpageCss->getCssFileContents($this->request->data['WebpageCss']['name'], $this->theme);
			if($cssFileContents)	{
				$this->request->data['WebpageCss']['content'] = $cssFileContents; 
			}
		}
		$types = $this->WebpageCss->types();
		$webpages = $this->WebpageCss->Webpage->find('list', array('conditions' => array('Webpage.type' => 'template')));
		$this->set(compact('types', 'webpages'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for webpage css', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->WebpageCss->remove($id, $this->theme)) {
			$this->Session->setFlash(__('Webpage css deleted', true));
			$this->redirect(array('action'=>'index'));
		} else {
			$this->Session->setFlash(__('Error!', true));
			$this->redirect(array('action'=>'index'));
		}
			
	}
	
}
?>