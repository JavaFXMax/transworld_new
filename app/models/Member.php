<?php

class Member extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		 'mname' => 'required',
		 'membership_no' => 'required',
		 'branch_id' => 'required',
		 'phone' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function branch(){

		return $this->belongsTo('Branch');
	}

	public function group(){

		return $this->belongsTo('Group');
	}

	public function kins(){

		return $this->hasMany('Kin');
	}


	public function savingaccounts(){

		return $this->hasMany('Savingaccount');
	}


	public function shareaccount(){

		return $this->hasOne('Shareaccount');
	}

	public function vehicles(){

		return $this->hasMany('Vehicle');
	}



	public function loanaccounts(){

		return $this->hasMany('Loanaccount');
	}

	public function documents(){

		return $this->hasMany('Document');
	}


	public function guarantors(){

		return $this->hasMany('Loanguarantor');
	}



	public static function getMemberAccount($id){

		$account_id = DB::table('savingaccounts')->where('member_id', '=', $id)->pluck('id');

		$account = Savingaccount::find($account_id);

		return $account;
	}

	public static function getMemberName($id){

		$member = Member::find($id);

		return $member->name;
	}

	public static function getMemberNo($id){

		$member = Member::find($id);

		return $member->membership_no;
	}
    
    public static function checkContribution($member_id, $type){
        /*Get The member*/
        $member= Member::where('id','=',$member_id)->get()->first();
        /*Get The Share Account*/
        $shareaccount= Shareaccount::where('member_id','=',$member_id)->get()->first();
        
        $share_transactions=  Sharetransaction::where('shareaccount_id','=',$shareaccount->id)
                ->where('type','=','credit')->where('pay_for','=','shares')->sum('amount');
        
        $membership_transactions= Sharetransaction::where('shareaccount_id','=',$shareaccount->id)
                ->where('type','=','credit')->where('pay_for','=','membership')->sum('amount');
        if($type == 'shares' && $share_transactions >= $member->total_shares){
             return $status= 'paid';
        }
        
        if($type == 'membership' && $membership_transactions >= $member->total_membership){
            return $status= 'paid';
        }
        
    }
}