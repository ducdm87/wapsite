<?php

class BH_Payment
{
	// URL checkout của baokim.vn
	private $payment_url = 'http://pay.bhmedia.dev/payment/customize_payment';
	private $url_get_main_balances = "http://pay.bhmedia.dev/service/get_balances";

	// Mã merchante site 
	private $app_id = '123456';	// Biến này được baokim.vn cung cấp khi bạn đăng ký merchant site

	// Mật khẩu bảo mật
	private $secure_pass = '123456!@#$%^'; // Biến này được baokim.vn cung cấp khi bạn đăng ký merchant site

	/**
	 * Hàm xây dựng url chuyển đến BaoKim.vn thực hiện thanh toán, trong đó có tham số mã hóa (còn gọi là public key)
	 * @param $order_id				Mã đơn hàng
	 * @param $business 			Email tài khoản người bán
	 * @param $total_amount			Giá trị đơn hàng
	 * @param $shipping_fee			Phí vận chuyển
	 * @param $tax_fee				Thuế
	 * @param $order_description	Mô tả đơn hàng
	 * @param $url_success			Url trả về khi thanh toán thành công
	 * @param $url_cancel			Url trả về khi hủy thanh toán
	 * @param $url_detail			Url chi tiết đơn hàng
	 * @return url cần tạo
	 */
	public function createRequestUrl($order_id, $business, $total_amount, $shipping_fee, $tax_fee, $order_description, $url_success, $url_cancel, $url_detail)
	{
		//die('+++');
		// Mảng các tham số chuyển tới baokim.vn
		$params = array(
			'app_id'		=>	strval($this->app_id),
			'order_id'			=>	strval($order_id),
			'business'			=>	strval($business),
			'total_amount'		=>	strval($total_amount),
			'shipping_fee'		=>  strval($shipping_fee),
			'tax_fee'			=>  strval($tax_fee),
			'order_description'	=>	strval($order_description),
			'url_success'		=>	strtolower($url_success),
			'url_cancel'		=>	strtolower($url_cancel),
			'url_detail'		=>	strtolower($url_detail)
		);
		ksort($params);
		
		$str_combined = $this->secure_pass.implode('', $params);
		$params['checksum'] = strtoupper(md5($str_combined));
		
		//Kiểm tra  biến $redirect_url xem có '?' không, nếu không có thì bổ sung vào
		$redirect_url = $this->payment_url;
		if (strpos($redirect_url, '?') === false)
		{
			$redirect_url .= '?';
		}
		else if (substr($redirect_url, strlen($redirect_url)-1, 1) != '?' && strpos($redirect_url, '&') === false)
		{
			// Nếu biến $redirect_url có '?' nhưng không kết thúc bằng '?' và có chứa dấu '&' thì bổ sung vào cuối
			$redirect_url .= '&';			
		}
				
		// Tạo đoạn url chứa tham số
		$url_params = '';
		foreach ($params as $key=>$value)
		{
			if ($url_params == '')
				$url_params .= $key . '=' . urlencode($value);
			else
				$url_params .= '&' . $key . '=' . urlencode($value);
		}
		return $redirect_url.$url_params;
	}
	
	/**
	 * Hàm thực hiện xác minh tính chính xác thông tin trả về từ BaoKim.vn
	 * @param $_GET chứa tham số trả về trên url
	 * @return true nếu thông tin là chính xác, false nếu thông tin không chính xác
	 */
	public function verifyResponseUrl($_GET = array())
	{
		$checksum = $_GET['checksum'];
		unset($_GET['checksum']);
		
		ksort($_GET);
		$str_combined = $this->secure_pass.implode('', $_GET);

        // Mã hóa các tham số
		$verify_checksum = strtoupper(md5($str_combined));
		
		// Xác thực mã của chủ web với mã trả về từ baokim.vn
		if ($verify_checksum === $checksum) 
			return true;
		
		return false;
	}
	
	public function get_main_balances($username)
	{
		$params	=	array(
					'username'	=>	strval($username),
					'app_id'	=>	strval($this->app_id)
				);
		
		ksort($params);
		$code = $this->secure_pass.implode('', $params);
		$code	=	strtoupper(md5($code));
		
		$params['code']	=	$code;
		
		$redirect_url	=	$this->url_get_main_balances;
		
		if (strpos($redirect_url, '?') === false)
		{
			$redirect_url .= '?';
		}
		else if (substr($redirect_url, strlen($redirect_url)-1, 1) != '?' && strpos($redirect_url, '&') === false)
		{
			// Nếu biến $redirect_url có '?' nhưng không kết thúc bằng '?' và có chứa dấu '&' thì bổ sung vào cuối
			$redirect_url .= '&';
		}
		
		$url_params = '';
		foreach ($params as $key=>$value)
		{
			if ($url_params == '')
				$url_params .= $key . '=' . urlencode($value);
			else
				$url_params .= '&' . $key . '=' . urlencode($value);
		}
		$url	=	$redirect_url.$url_params;
		return $this->execCURL($url);
	}
	
	function execCURL($url) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:13.0) Gecko/20100101 Firefox/13.0.1');
	
		return curl_exec($ch);
	}
}
?>