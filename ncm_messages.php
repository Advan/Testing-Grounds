<?php
class Ncm_messages extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->model('Ncm_common');
	}

	public function ComposeMessage($To='', $Subject='', $Message='', $Priority='Normal', $Type='Pro2Pro', $SubType='Interview', $Attachments='Candidates', $URL='', $InterviewDate='', $AlternateDate=''){
	/* Composes a Message to a Candidate/Colleague. Also, contains options to setup interview requests to a Candidate or provide a Colleague with Candidate Lists/Watch Lists.
	 *
	 * PARAMETERS
	 *	$To				[VarChar]	Required	UserID or Temp URL of a User.
	 *	$Subject		[VarChar]	Required	Subject of the Message.
	 *	$Message		[VarChar]	Required	Contents of the Message.
	 *	$Priority		[VarChar]	Optional	('Low','Normal','High').
	 *	$Type			[VarChar]	Required	('Pro2Pro','Pro2ExternalPro','Pro2User','User2Pro','User2User').
	 *	$SubType		[VarChar]	Optional	('Interview','Support','Ping','Message').
	 *	$Attachments	[VarChar]	Optional	('WatchList','CompareList','Candidates','None').
	 *	$URL			[VarChar]	Optional	URL of the User
	 *	$InterviewDate	[Int]		Optional	Interview Date and Time
	 *	$AlternateDate	[Int]		Optional	Alternate Interview Date and Time
	 *
	 * USAGE
	 *		ComposeMessage(1002, 'Subject goes here', 'Message content goes here', 'Normal', 'Pro2Pro', 'Message', 'None', '', '', '');
	 *			Returns: TRUE/FALSE
	  */
		$UserID = $this->session->userdata('USER_ID');
		if($UserID && $To && $Subject && $Message){
			//Truncate all variables so there's no DB issues.
			$To 		= substr($To, 0, 255);
			$Subject 	= substr($Subject, 0, 255);
			//Replace all returns within the Message
			$FilterMsg	= $this->Ncm_common->ReplaceCR($Message, ' ');
			//Replace all quotes (double and single) with valid HTML characters.
			$Message 	= $this->Ncm_common->ReplaceQuotes($FilterMsg);
			//Insert into messages__
			$MessagesInsert = array(
				'messages_id'	=> 0,
				'from' 			=> $UserID,
				'date'			=> $this->Ncm_common->ISOTime(),
				'ip'			=> $this->Ncm_common->IP(),
				'op'			=> 1
			);
			$this->db->insert('messages__', $MessagesInsert);
			$MessagesID = $this->db->insert_id();
			//Update the messages_id with the correct ID just inserted.
			$MessagesIDUpdateArray = array(
				'messages_id'	=> $MessagesID
			);
			$this->db->where('messages__.id', $MessagesID);
			$this->db->where('messages__.from', $UserID);
			$this->db->update('messages__', $MessagesIDUpdateArray);
		
			$MessagesPropertiesInsert = array(
				'messages_id' 		=> $MessagesID,
				'type'				=> $Type,
				'sub_type'			=> $SubType,
				'author_deleted' 	=> 0,
				'retracted'			=> 0,
				'priority'			=> $Priority,
				'reply_to'			=> 0
			
			);
			$this->db->insert('messages__properties', $MessagesPropertiesInsert);
		
			$MessageAttachmentsInsert = array(
				'messages_id'	=> $MessagesID,
				'attachments'	=> $Attachments,
				'url'			=> $URL
			);
			$this->db->insert('messages__attachments', $MessageAttachmentsInsert);
		
			$MessagesDataInsert = array(
				'messages_id' 	=> $MessagesID,
				'subject' 		=> $Subject,
				'content'		=> $Message
			);
			$this->db->insert('messages__data', $MessagesDataInsert);
		
			$MessagesToInsert 	= '';
			//explode the $To at the , you'll be expecting a series of user id's
			$ToExplode 			= explode(',', $To);
			//Loop through the array and
			foreach($ToExplode as $To){
				//check if the ID is legit, if it is insert it.
				if(is_numeric($To)){
					$MessagesToInsert[] = array(
						'messages_id' 	=> $MessagesID,
						'to'			=> $To,
						'opened'		=> 0,
						'read'			=> 0,
						'deleted'		=> 0,
						'important'		=> 0
					);
				}
				if(!is_numeric($To)){
					//If this a custom URL.
					if(strstr($To, '.')){
						$URLType = 'C';
					}
					//If this is a standard URL.
					else {
						$URLType = 'P';
					}
					$To = $this->Ncm_profile->GetProfileUserID($URLType, $To);
					$MessagesToInsert[] = array(
						'messages_id' 	=> $MessagesID,
						'to'			=> $To,
						'opened'		=> 0,
						'read'			=> 0,
						'deleted'		=> 0,
						'important'		=> 0
					);
				}
			}
			//Batch insert all To's
			$this->db->insert_batch('messages__to', $MessagesToInsert);
		
			//If an Interview is taking place, insert into messages__interview.
			if($InterviewDate && is_numeric($InterviewDate)){
				//if the alternate date isn't numeric, set it to nothing.
				if($AlternateDate && !is_numeric($AlternateDate)){
					$AlternateDate = '';
				}
				$MessagesInterviewInsert = array(
					'messages_id' 		=> $MessagesID,
					'interview_date' 	=> $InterviewDate,
					'alternate_date'	=> $AlternateDate
				);
				$this->db->insert('messages__interview', $MessagesInterviewInsert);
			}
			return true;
		}
		return false;
	}

	public function GetInbox(){
	/* Get's the Inbox pertaining to the UserID.
	 *
	 * USAGE
	 *		GetInbox();
	 *			Returns: Query
	  */
		$UserID = $this->session->userdata('USER_ID');
		if($UserID){
			//Get my related message ID's
			/*$Query = $this->db->query('
				SELECT `messages__to`.`messages_to_id`, `messages__to`.`messages_id`, `messages__`.`date`
				FROM (`messages__to`)
				(SELECT `messages__to`.`messages_to_id`, `messages__to`.`messages_id` FROM (`messages__to`) ORDER BY `messages__to`.`messages_to_id` DESC)
				LEFT JOIN `messages__` ON `messages__`.`id` = `messages__to`.`messages_to_id`
				LEFT JOIN `messages__properties` ON `messages__properties`.`messages_properties_id` = `messages__to`.`messages_to_id`
				WHERE `messages__to`.`to` =  '.$UserID.'
				ORDER BY `messages__`.`date` DESC
			');
			echo '<pre>';
			print_r($Query->result());
			echo '<p>'.$this->db->last_query();
			die;*/
		
			$this->db->select('messages__to.messages_to_id, messages__to.messages_id, messages__.date');
			$this->db->where('messages__to.to', $UserID);
			$this->db->join('messages__', 'messages__.id = messages__to.messages_to_id', 'left');
			$this->db->join('messages__properties', 'messages__properties.messages_properties_id = messages__to.messages_to_id', 'left');
			$this->db->order_by('messages__.date', 'DESC');
			$this->db->group_by('messages__to.messages_id');
			$GetMyMessagesIDs = $this->db->get('messages__to');
		
			//If I have messages, get the contents of them.
			if($GetMyMessagesIDs->num_rows() > 0){
				$this->db->select('messages__.messages_id, messages__.from, messages__to.to, messages__to.read, messages__.date, messages__.ip, messages__data.subject, messages__data.content, messages__properties.sub_type, messages__properties.retracted, messages__properties.sub_type, messages__properties.priority, user__names.first_name, user__names.middle_name, user__names.last_name, user__url.temp, user__url.thumb_path, user__thumbs_photo.thumb');
				$this->db->where('messages__to.to', $UserID);
				$this->db->where('messages__.op', 1);
				$this->db->where('messages__properties.reply_to', 0);
				foreach($GetMyMessagesIDs->result() as $row){
					$this->db->or_where('messages__to.messages_to_id', $row->messages_to_id);
				}
				$this->db->join('messages__to', 'messages__to.messages_to_id = messages__.id', 'left');
				$this->db->join('messages__data', 'messages__data.messages_data_id = messages__.id', 'left');
				$this->db->join('messages__properties', 'messages__properties.messages_properties_id = messages__.id', 'left');
				$this->db->join('user__names', 'user__names.user_names_id = messages__.from AND user__names.status = "Current"', 'left');
				$this->db->join('user__url', 'user__url.user_url_id = messages__.from', 'left');
				$this->db->join('user__thumbs_photo', 'user__thumbs_photo.user_id = messages__.from AND user__thumbs_photo.status = 1', 'left');
				$this->db->order_by('messages__.date', 'DESC');
				$GetInbox = $this->db->get('messages__');
				return $GetInbox;
			}
		}
		return false;
	}

	public function OrdinalSuffix($Number=''){
	/* Adds an ordinal suffix (st, nd, rd, th) to the end of the $Number.
	 *
	 * PARAMETERS
	 *	$Number		[INT]	Required	A whole numbers.
	 *
	 * USAGE
	 *		OrdinalSuffix(1);
	 *			Returns: 1st
	 *
	 *		OrdinalSuffix(2);
	 *			Returns: 2nd
	  */

		$T = $this->Ncm_common->IncludeLanguage();
		$Number = round($Number);
		if($Number < 11 || $Number > 13){
	
			switch($Number % 10){
				case 1: return $Number.$T['_1390'];	// st
				case 2: return $Number.$T['_1391'];	// nd
				case 3: return $Number.$T['_1392'];	// rd
			}
		}
		return $Number.$T['_1393'];	// th
	}
}
?>

