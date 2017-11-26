<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use App\Services\WebUntis;

class WebUntisController extends Controller {
	public $webuntis;
	public function __construct(  ) {
		$this->webuntis = new WebUntis();
	}

	public function GetSchools() {
		$ids = collect($this->webuntis->request('GET', "schools"))->map(function($item){
			return $item->untis_id;
		})->implode(',');
		return $this->webuntis->request("GET", "schools?untis_ids=$ids");
	}

	public function GetTeachers(  ) {
		$ids = collect($this->webuntis->request('GET', "teachers"))->map(function($item){
			return $item->untis_id;
		})->implode(',');
		return $this->webuntis->request("GET", "teachers?untis_ids=$ids");
	}

	public function GetSubjects(  ) {
		$ids = collect($this->webuntis->request('GET', "subjects?name=pes"))->map(function($item){
			return $item->untis_id;
		})->chunk(250);
		foreach ($ids as $ids_chuck){
			$res = array_merge($res = [], $this->webuntis->request("GET", "subjects?untis_ids=".$ids_chuck->implode(',')));
		}
		return $res;
	}

	public function GetDepartments(  ) {
		$ids = collect($this->webuntis->request('GET', "departments"))->map(function($item){
			return $item->untis_id;
		})->implode(',');
		return $this->webuntis->request("GET", "departments?untis_ids=$ids");
	}

	public function GetGroups(  ) {
		// opbwu17fint = 2353
		$ids = collect($this->webuntis->request('GET', "groups?active=true"))->map(function($item){
			return $item->untis_id;
		})->chunk(150);
		$res = [];
		foreach ($ids as $ids_chuck){
			$res = array_merge($res, $this->webuntis->request("GET", "groups?untis_ids=".$ids_chuck->implode(',')));
		}
		return $res;
	}

	public function GetStudents(  ) {
		$ids = collect($this->webuntis->request('GET', "students?active=true"))->map(function($item){
			return $item->untis_id;
		})->chunk(150);
		$res = [];
		foreach ($ids as $ids_chuck){
			$res = array_merge($res, $this->webuntis->request("GET", "students?untis_ids=".$ids_chuck->implode(',')));
		}
		return $res;
	}

	public function GetUsers(  ) {
		$ids = collect($this->webuntis->request('GET', "users"))->map(function($item){
			return $item->untis_id;
		})->implode(',');
		return $this->webuntis->request("GET", "users?untis_ids=$ids");
	}

	public function GetUserGroups(  ) {
		$ids = collect($this->webuntis->request('GET', "usergroups"))->map(function($item){
			return $item->untis_id;
		})->implode(',');
		return $this->webuntis->request("GET", "usergroups?untis_ids=$ids");
	}

	public function GetLessons() {
		$ids = collect($this->webuntis->request('GET', "groups/2353/lessons"))->map(function($item){
			return $item->untis_id;
		})->implode(',');

		$lessons = $this->webuntis->request("GET", "lessons?untis_ids=$ids");
		$subject_ids = collect($lessons)->map(function($item){
			return $item->subjects[0];
		})->implode(',');

		$subjects = $this->webuntis->request("GET", "subjects?untis_ids=$subject_ids");

		foreach($lessons as $lesson){
			foreach($subjects as $subject){
				if($lesson->subjects[0] == $subject->untis_id){
					$lesson->subjects = $subject->name;
				}
			}
		}
		return $lessons;
	}

	public function GetLessonsWeekly($start = null, $end = null) {
		$start = $start == null ? Carbon::now()->startOfWeek()->format('Y-m-d') : $start;
		$end = $end == null ?  Carbon::now()->endOfWeek()->format('Y-m-d') : $end;

		$ids = collect($this->webuntis->request('GET', "groups/2353/lessons?start=$start&end=$end"))->map(function($item){
			return $item->untis_id;
		})->implode(',');

		$lessons = $this->webuntis->request("GET", "lessons?untis_ids=$ids");
		$subject_ids = collect($lessons)->map(function($item){
			return $item->subjects[0];
		})->implode(',');

		$subjects = $this->webuntis->request("GET", "subjects?untis_ids=$subject_ids");

		foreach($lessons as $lesson){
			foreach($subjects as $subject){
				if($lesson->subjects[0] == $subject->untis_id){
					$lesson->subjects = $subject->name;
				}
			}
		}
		return $lessons;
	}

}
