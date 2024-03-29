<?php

/**
 * 计划任务
 * User:storm
 * Date: 2017/4/19
 * Time: 9:13
 */
class Crontab extends \MY_Controller
{
	public function __construct ()
	{
		parent::__construct ();
		set_time_limit ( 100 );
		$this->load->model ( 'facade/order_facade' );
        $this->load->model ( 'logic/order_to_financepanel_logic' );
        $this->load->model ('data/finance_data');
	}

	/**
	 * 测试的
	 */
	public function test ()
	{
		echo 'allow access';
	}

	/**
	 * 每分钟都执行的计划任务
	 */
	public function run_every_minute ()
	{
	}

	/**
	 * 每小时都执行
	 */
	public function run_every_hour ()
	{
	}

	/**
	 * 每天1点都执行的计划任务
	 */
	public function run_every_day ()
	{
	}

	/**
	 * 每周星期一都执行的计划任务
	 */
	public function run_every_week ()
	{
	}

	/**
	 * 每月1号都执行的计划任务
	 */
	public function run_every_month ()
	{
	}

}