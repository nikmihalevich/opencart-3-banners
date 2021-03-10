<?php
class ControllerExtensionModuleBannersNik extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/banners_nik');

		static $module = 0;

		$this->load->model('tool/image');

		$data = $setting;
//		var_dump($setting);

        if ($this->request->server['HTTPS']) {
            $data['image'] = $this->config->get('config_ssl') . 'image/' . $setting['bg'];
        } else {
            $data['image'] = $this->config->get('config_url') . 'image/' . $setting['bg'];
        }

        $data['text'] = html_entity_decode($setting['text']);


		$data['module'] = $module++;

        return $this->load->view('extension/module/banners_nik', $data);
	}
}