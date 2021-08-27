<?php

/**
 * Ket thua tu class Model
 */
class HomeModel extends Model
{
	protected $_table = 'pets';

	public function __construct()
	{
		parent::__construct();
	}

	// 
    public function tableFill() {
        return 'pets';
    }

    public function fieldFill() {
    	return 'pet_name, breed_type';
    }

    public function primaryKey() {
    	return 'id_pet';
    }

	public function getDetail($id) {
		$data = [
			'item 1',
			'item 2',
			'item 3'
		];

		return $data[$id];
	}

	public function getListStories() {
		// $data = $this ->db->table('stories')->where('id_story', '>', 0)->whereLike('meta', '%Agility%')->select('id_story, title')->orderBy('id_story', 'DESC')->limit(3, 3)->get();

		$data = $this->db->table('stories')->join('storydetails', 'stories.id_story = storydetails.id_story')->limit(3)->get();

		return $data;
	}

	public function getDetailStories($name) {
		$data = $this->db->table('stories')->where('id_story', '=', $name)->select('id_story, title')->first();

		return $data;
	}

	public function insertUsers($data) {
		$this->db->table('user')->insert($data);
		return $this->db->lastId();
	}

	public function updateUsers($data, $id) {
		$this->db->table('user')->where('id_user', '=', $id)->update($data);
	}

	public function deleteUsers($id) {
		$this->db->table('user')->where('id_user', '    =', $id)->delete();
	}
}