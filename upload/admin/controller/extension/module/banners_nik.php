<?php
class ControllerExtensionModuleBannersNik extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/banners_nik');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('banners_nik', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['bg'])) {
			$data['error_bg'] = $this->error['bg'];
		} else {
			$data['error_bg'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/banners_nik', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/banners_nik', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/banners_nik', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/banners_nik', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

        $this->load->model('tool/image');

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['display_heading'])) {
			$data['display_heading'] = $this->request->post['display_heading'];
		} elseif (!empty($module_info)) {
			$data['display_heading'] = $module_info['display_heading'];
		} else {
			$data['display_heading'] = 0;
		}

        if (isset($this->request->post['text'])) {
            $data['text'] = $this->request->post['text'];
        } elseif (!empty($module_info)) {
            $data['text'] = $module_info['text'];
        } else {
            $data['text'] = '';
        }

        if (isset($this->request->post['bg'])) {
            $data['bg']    = $this->request->post['bg'];
        } elseif (!empty($module_info)) {
            $data['bg']    = $module_info['bg'];
        } else {
            $data['bg']    = '';
        }

        $data['thumb'] = $data['bg'] ? $this->model_tool_image->resize($data['bg'], 100, 100) : $this->model_tool_image->resize('no_image.png', 100, 100);

        if (isset($this->request->post['link'])) {
            $data['link'] = $this->request->post['link'];
        } elseif (!empty($module_info)) {
            $data['link'] = $module_info['link'];
        } else {
            $data['link'] = '';
        }

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($module_info)) {
			$data['width'] = $module_info['width'];
		} else {
			$data['width'] = '';
		}

		if (isset($this->request->post['width_unit'])) {
			$data['width_unit'] = $this->request->post['width_unit'];
		} elseif (!empty($module_info)) {
			$data['width_unit'] = $module_info['width_unit'];
		} else {
			$data['width_unit'] = 0;
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($module_info)) {
			$data['height'] = $module_info['height'];
		} else {
			$data['height'] = '';
		}

		if (isset($this->request->post['height_unit'])) {
			$data['height_unit'] = $this->request->post['height_unit'];
		} elseif (!empty($module_info)) {
			$data['height_unit'] = $module_info['height_unit'];
		} else {
			$data['height_unit'] = 0;
		}

		if (isset($this->request->post['padding'])) {
			$data['padding'] = $this->request->post['padding'];
		} elseif (!empty($module_info)) {
			$data['padding'] = $module_info['padding'];
		} else {
			$data['padding'] = '';
		}

		if (isset($this->request->post['class'])) {
			$data['class'] = $this->request->post['class'];
		} elseif (!empty($module_info)) {
			$data['class'] = $module_info['class'];
		} else {
			$data['class'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

        $data['img_placeholder'] = $this->model_tool_image->resize('no_image.png', 40, 40);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/banners_nik', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/banners_nik')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!$this->request->post['bg']) {
			$this->error['bg'] = $this->language->get('error_bg');
		}

		return !$this->error;
	}
}
