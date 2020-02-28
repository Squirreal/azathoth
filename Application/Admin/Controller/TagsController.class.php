<?php
/**
 * User: chrisz
 * Date: 2019/5/26
 * Time: 14:31
 */

namespace Admin\Controller;

class TagsController extends BaseController {
    const TAG = 'Tags';
    private $m;

    public function __construct() {
        parent::__construct();

        $this->checkLogin();
        $this->m = M('common_tags');
    }

    public function __call($action, $arguments) {
        //权限控制
        $this->userCan('Buildings') || $this->userCan('Presales');
        
        if (!method_exists($this, $action))     $this->setError('未知操作！');
        $this->$action($arguments);
    }

    /**
     * @TODO 标签列表
     */
    private function index() {
        $source_id = variable_get(I('post.source_id'));
        $type = absint(I('post.type'));

        $tags = $this->m
            ->where(['source_id' => $source_id, 'type' => $type, 'status' => 1])
            ->order('tag_id DESC')
            ->field('tag_id AS id,name_cn,name_en,intro_cn AS intro,icon,created_time AS time')
            ->select();
        if ($tags) {
            foreach ($tags as $k => $v) {
                $tags[$k]['id'] = variable_set('tag.id', $v['id']);
                $tags[$k]['icon'] = $v['icon'] ? C('FILES_SERVER').$v['icon'] : '';
                $tags[$k]['source_id'] = I('post.source_id');
            }
        }

        $this->response = ['status' => 'y', 'data' => $tags];
        $this->sendResponse();
    }

    /**
     * @TODO 添加标签
     */
    private function add() {
        $data = [
            'type' => absint(I('post.type')),
            'source_id' => variable_get(I('post.source_id')),
            'name_cn' => I('post.name_cn'),
            'name_en' => I('post.name_en'),
            'intro_cn' => I('post.intro_cn'),
            'intro_en' => I('post.intro_en'),
            'icon' => I('post.icon')['file'],
            'status' => 1,
            'created_by' => $this->uid,
            'created_time' => date('Y-m-d H:i:s'),
        ];

        if (!$data['name_cn'])          E('请输入标签中文名称');
        if (!$data['name_en'])          E('请输入标签英文名称');
        if (!$data['icon'])             E('请上传图标');


        $check = $this->m->where(['name_cn' => $data['name_cn'], 'type' => $data['type'], 'source_id' => $data['source_id'], 'status' => 1])->getField('tag_id');
        if ($check)                     E('已经添加过了');

        $this->m->startTrans();
        if ($this->m->add($data)) {
            $this->m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $this->m->rollback();
        }

        $this->sendResponse();
    }

    /**
     * @TODO 编辑标签
     */
    private function modify() {
        $id = variable_get(I('post.id'));
        $type = absint(I('post.type'));

        if (!$id)               		E('请选择需要更新的标签');

        $tag = $this->m->where(['tag_id' => $id, 'status' => 1])->find();
        if (!$tag)          		E('数据不存在或已被删除');

        $data = [
            'name_cn' => I('post.name_cn'),
            'name_en' => I('post.name_en'),
            'intro_cn' => I('post.intro_cn'),
            'intro_en' => I('post.intro_en'),
            'icon' => I('post.icon')['file'],
            'modified_by' => $this->uid,
            'modified_time' => date('Y-m-d H:i:s'),
        ];

        if (!$data['name_cn'])          E('请输入标签中文名称');
        if (!$data['name_en'])          E('请输入标签英文名称');
        if (!$data['icon'])             E('请上传图标');

        $check = $check = $this->m->where(['name_cn' => $data['name_cn'], 'type' => $type, 'source_id' => $data['source_id'], 'status' => 1, 'tag_id' => ['NEQ', $id]])->getField('tag_id');
        if ($check)                     E('该标签已存在');

        $this->m->startTrans();
        $update = $this->m->where(['tag_id' => $id])->save($data);
        if ($update) {
            $this->m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $this->m->rollback();
        }

        $this->sendResponse();
    }

    /**
     * @TODO 删除标签
     */
    private function remove() {
        $id = variable_get(I('post.id'));
        if (!$id)               E('请选择需要删除的标签');

        $tag = $this->m->where(['tag_id' => $id, 'status' => 1])->find();
        if (!$tag)          E('数据不存在或已被删除');

        $this->m->startTrans();
        $update = $this->m->where(['tag_id' => $id])->save([
            'status' => -1,
            'modified_by' => $this->uid,
            'modified_time' => date('Y-m-d H:i:s')
        ]);
        if ($update) {
            $this->m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $this->m->rollback();
        }

        $this->sendResponse();
    }

    /**
     * @TODO 标签信息
     */
    private function info() {
        $id = variable_get(I('post.id'));
        if (!$id)               E('请选择标签');

        $tag = $this->m
            ->where(['tag_id' => $id, 'status' => 1])
            ->field('source_id,type,tag_id AS id,name_cn,name_en,intro_cn,intro_en,icon')
            ->find();
        if (!$tag)          	E('数据不存在或已被删除');

        $tag['id'] = I('post.id');
        $tag['source_id'] = variable_set('building.id', $tag['source_id']);
        $tag['icon'] = [
            'url' => $tag['icon'] ? C('FILES_SERVER').$tag['icon'] : '',
            'file' => $tag['icon']
        ];

        $this->response = ['status' => 'y', 'data' => $tag];

        $this->sendResponse();
    }
}