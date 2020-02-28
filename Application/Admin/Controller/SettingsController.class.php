<?php
/**
 * User: chrisz
 * Date: 2019/5/26
 * Time: 14:31
 */

namespace Admin\Controller;

class SettingsController extends BaseController {

    public function __construct() {
        parent::__construct();

        $this->checkLogin();
    }

    public function index() {

        $this->sendResponse();
    }

    /**
     * 获取系统用户组
     */
    public function getSysGroups() {
        $this->userCan('Settings_Groups');

        $groups = M('sys_groups')
            ->where(array('status' => 1))
            ->field('group_id,name,privileges,created_time')
            ->order('group_id ASC')
            ->select();
        if ($groups) {
            $m_users = M('sys_users');
            foreach ($groups as $k => $v) {
                $groups[$k]['user_count'] = $m_users->where(array('group_id' => $v['group_id'], 'status' => 1))->count();
                $groups[$k]['group_id'] = variable_set('sys.group.id', $v['group_id']);
            }
        }
        $this->response = array('status' => 'y', 'data' => $groups);
        $this->sendResponse();
    }

    /**
     * 添加系统用户组
     */
    public function addSysGroup() {
        $this->userCan('Settings_Group_Add');

        $name = I('post.groupName');
        $privileges = I('post.groupPrivileges');

        $m = M('sys_groups');
        if (!$name)            $this->setError('请输入用户组名称');
        if ($m->where(array('name' => $name, 'status' => 1))->find()) {
            $this->setError('该用户组已经添加过了');
        }
        if ($privileges) {
            foreach ($privileges as $k => $v) {
                if (!$v)    unset($privileges[$k]);
            }
        }
        $m->add(array(
            'name' => $name,
            'privileges' => implode(',', $privileges),
            'created_by' => $this->uid,
        ));

        user_log($this->uid, __CLASS__, 'action', __FUNCTION__ , 1, $this->userinfo['name'], '添加了系统用户组');

        $this->response = array('status' => 'y');

        $this->sendResponse();
    }

    /**
     * 删除系统用户组
     */
    public function removeSysGroup() {
        $this->userCan('Settings_Group_Remove');

        $group_id = variable_get(I('post.groupId'));
        $m = M('sys_groups');
        $m_users = M('sys_users');

        if ($group_id == 1)     $this->setError('系统预定义数据，不可删除');
        if ($m_users->where(array('group_id' => $group_id, 'status' => array('EGT', 0)))->count()) {
            $this->setError('该用户组下面还存在用户，请先删除用户');
        }
        $m->where(array('group_id' => $group_id))->save(array(
            'status' => -1,
            'modified_by' => $this->uid,
            'modified_time' => date('Y-m-d H:i:s')
        ));
        user_log($this->uid, __CLASS__, 'action', __FUNCTION__ , 1, $this->userinfo['name'], '删除了系统用户组');

        $this->response = array('status' => 'y');

        $this->sendResponse();
    }

    /**
     * 更改系统用户组
     */
    public function modifySysGroup() {
        $this->userCan('Settings_Group_Modify');

        $name = I('post.groupName');
        $privileges = I('post.groupPrivileges');

        $group_id = variable_get(I('post.groupId'));
        $m = M('sys_groups');

        if ($m->where(array('name' => $name, 'status' => 1, 'group_id' => array('NEQ', $group_id)))->find()) {
            $this->setError('该用户组已经存在');
        }

        if ($privileges) {
            foreach ($privileges as $k => $v) {
                if (!$v)    unset($privileges[$k]);
            }
        }

        if (!$name)            $this->setError('请输入用户组名称');
        $m->where(array('group_id' => $group_id))->save(array(
            'name' => $name,
            'privileges' => implode(',', $privileges),
            'modified_by' => $this->uid,
            'modified_time' => date('Y-m-d H:i:s')
        ));

        user_log($this->uid, __CLASS__, 'action', __FUNCTION__ , 1, $this->userinfo['name'], '更新了系统用户组信息');

        $this->response = array('status' => 'y');

        $this->sendResponse();
    }

    /**
     * 获取系统用户列表
     */
    public function getSysUsers() {
        $this->userCan('Settings_Users');

        $users = M('sys_users u')
            ->join('LEFT JOIN __SYS_GROUPS__ g ON u.group_id=g.group_id')
            ->where(array('u.status' => array('EGT', 0)))
            ->field('u.uid,u.username,u.name,u.mobile,g.name AS group_name,g.group_id,u.last_time,u.last_ip,u.status,u.created_time')
            ->order('u.uid ASC')
            ->select();
        if ($users) {
            foreach ($users as $k => $v) {
                $users[$k]['uid'] = variable_set('sys.user.id', $v['uid']);
                $users[$k]['group_id'] = variable_set('sys.group.id', $v['group_id']);
                $users[$k]['status_txt'] = $v['status'] == 1 ? '正常' : '禁用';
            }
        }
        $this->response = array('status' => 'y', 'data' => $users);
        $this->sendResponse();
    }

    /**
     * 添加系统用户
     */
    public function addSysUser() {
        $this->userCan('Settings_User_Add');

        if (I('post.username') && I('post.password')) {
            $m = M('SysUsers');
            $data = array(
                'username' => I('post.username'),
                'name' => I('post.name'),
                'group_id' => variable_get(I('post.group')),
                'password' => md5(md5(I('post.password'))),
                'created_by' => $this->uid,
                'status' => I('post.status'),
            );
            if ($data['username'] && $data['name'] && $data['group_id']) {
                if ($m->where(array('username' => $data['username']))->getField('uid')) {
                    $response['msg'] = '该用户已经添加过了';

                    user_log($this->uid, __CLASS__, 'action', __FUNCTION__, 0, $this->userinfo['name'], '尝试添加用户 ['.$data['name'].']， 但是该用户已经添加过了');
                } else {
                    $m->add($data);
                    $this->response = array('status' => 'y');

                    user_log($this->uid, __CLASS__, 'action', __FUNCTION__, 1, $this->userinfo['name'], '添加了用户 ['.$data['name'].']');
                }
            }
        }

        $this->sendResponse();
    }

    /**
     * 更改系统用户
     */
    public function modifySysUser() {
        $this->userCan('Settings_User_Modify');

        $uid = variable_get(I('post.uid'));
        $m = M('SysUsers');

        if (I('post.username') && I('post.name') && I('post.group')) {
            $data = array(
                'username' => I('post.username'),
                'name' => I('post.name'),
                'group_id' => variable_get(I('post.group')),
                'modified_time' => date('Y-m-d H:i:s'),
                'modified_by' => $this->uid,
                'status' => absint(I('post.status'))
            );
            if (I('post.password')) {
                $data['password'] = md5(md5(I('post.password')));
            }

            if ($uid == 1) {
                unset($data['group_id']);
                unset($data['status']);
            }

            $m->where(array('uid' => $uid))->save($data);
            $this->response = array('status' => 'y');

            user_log($this->uid, __CLASS__, 'action', __FUNCTION__, 1, $this->userinfo['name'], '更改了用户信息 ['.$data['name'].']');
        }
        $this->sendResponse();
    }

    /**
     * 删除系统用户
     */
    public function removeSysUser() {
        $this->userCan('Settings_User_Remove');

        $uid = absint(variable_get(I('post.uid')));
        $m = M('SysUsers');
        $name = $m->where(array('uid' => $uid))->getField('name');
        if ($uid) {
            if ($uid === 1){
                $this->setError('此用户为系统保留用户， 禁止删除！');
                user_log($this->uid, __CLASS__, 'action', __FUNCTION__, 0, $this->userinfo['name'], '尝试删除用户 ['.$name.']， 被禁止');
            } else {

                $m->where(array('uid' => $uid))->save(array('status' => -1));

                $this->response = array('status' => 'y');

                user_log($this->uid, __CLASS__, 'action', __FUNCTION__, 1, $this->userinfo['name'], '删除了用户 ['.$name.']');
            }
        }

        $this->sendResponse();
    }

    /**
     * 获取单位列表
     */
    public function getUnit() {
        $this->userCan('Settings_Unit');
        $unit = M('unit')
            ->where(array('status' => 1))
            ->order('unit_id DESC')
            ->field('unit_id AS id,name,created_time AS time')
            ->select();
        if ($unit) {
            foreach ($unit as $k => $v) {
                $unit[$k]['id'] = variable_set('unit.id', $v['id']);
            }
        }
        $this->response = array('status' => 'y', 'data' => $unit);
        $this->sendResponse();
    }

    /**
     * 添加单位
     */
    public function addUnit() {
        $this->userCan('Settings_Unit_Add');

        $name = I('post.name');
        if (!$name)         E('请输入单位名称');

        $m = M('unit');
        if ($m->where(['name' => $name, 'status' => 1])->find()) {
            E('该名称已经添加过了');
        }

        $m->add(array(
            'name' => $name,
            'created_by' => $this->uid,
            'created_time' => date('Y-m-d H:i:s'),
            'modified_by' => $this->uid,
            'modified_time' => date('Y-m-d H:i:s')
        ));

        $this->response = array('status' => 'y');
        $this->sendResponse();
    }

    /**
     * 编辑单位
     */
    public function modifyUnit() {
        $this->userCan('Settings_Unit_Modify');

        $name = I('post.name');
        $id = variable_get(I('post.id'));
        if (!$name)         E('请输入单位名称');

        $m = M('unit');
        if ($m->where(['name' => $name, 'status' => 1, 'unit_id' => ['NEQ', $id]])->find()) {
            E('该名称已经添加过了');
        }

        $m->where(['unit_id' => $id])->save(array(
            'name' => $name,
            'modified_by' => $this->uid,
            'modified_time' => date('Y-m-d H:i:s')
        ));

        $this->response = array('status' => 'y');
        $this->sendResponse();
    }

    /**
     * 删除单位
     */
    public function removeUnit() {
        $this->userCan('Settings_Unit_Remove');

        $id = variable_get(I('post.id'));

        M('unit')->where(['unit_id' => $id])->save(array(
            'status' => -1,
            'modified_by' => $this->uid,
            'modified_time' => date('Y-m-d H:i:s')
        ));

        $this->response = array('status' => 'y');
        $this->sendResponse();
    }
}