<?php
/**
 * @author：storm
 * Email：hi@yumufeng.com
 * Date: 2017/7/31 0031
 * Time: 14:24
 */
class Admin_user_org_data extends \Application\Component\Common\IData{

	public function __construct ()
	{
		parent::__construct ();
	}


	public function edit($id = 0,$auth_rule_ids = []){

		if(!is_numeric($id)){
			$this->set_error('未指定正确的用户');return false;
		}

		$lists = $this->get_field_by_where('o_id',['u_id'=>$id],true);

		$lists = $lists ? $lists:[];
		$lists  = array_column($lists,'o_id');

		$a = array_diff($lists,$auth_rule_ids); //删除
		$b = array_diff($auth_rule_ids,$lists); //新增

		if(!$a && !$b){
			return true;
		}

		try {

			$this->db->trans_strict(FALSE);
			$this->db->trans_begin();

			if(is_array($a) && !empty($a)){ //删除组织结构
				$ids = implode(',',$a);
				$sql = 'delete from admin_user_org where u_id = '.$id.' and o_id in ('.$ids.')';
				$query = $this->db->query($sql);
				if($this->db->affected_rows()<=0){
					$this->set_error('删除职位失败');return false;
				}
			}

			if(is_array($b) && !empty($b)){ //新增组织结构
				$sql = 'INSERT INTO admin_user_org (u_id,o_id)  VALUES ';
				foreach($b as $v){
					$sql .= '('.$id.','.$v.'),';
				}

				$sql = rtrim($sql,',');
				$query = $this->db->query($sql);
				if($this->db->affected_rows()<=0){
					$this->set_error('添加职位失败');return false;
				}
			}

			$this->db->trans_complete();
			return true;

		}catch(PDOException $e) {
			$this->db->trans_rollback();
			exit($e->getMessage());
		}
	}


	/**
	 * 查询列表
	 * @param int $o_id
	 * @return mixed
	 */
	public function user_list($o_id = 0){
		$sql = 'select b.* from admin_user_org a LEFT JOIN admin b on a.u_id=b.id where a.o_id='.$o_id;
		$query = $this->db->query($sql);
		$info = $query->result_array();
		return $info;
	}
}