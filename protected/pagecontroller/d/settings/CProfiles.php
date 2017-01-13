<?php
prado::using ('Application.MainPageD');
class CProfiles extends MainPageD {    
	public function onLoad($param) {		
		parent::onLoad($param);		
        $this->showProfiles=true;        
		if (!$this->IsPostBack&&!$this->IsCallBack) {	
            if (!isset($_SESSION['currentPageCache'])||$_SESSION['currentPageCache']['page_name']!='d.settings.Profiles') {
				$_SESSION['currentPageCache']=array('page_name'=>'d.settings.Profiles','page_num'=>0);												
			}            
            $this->populateData ();
		}
        
	}   
    public function populateData () {
        $this->cmbTheme->DataSource=$this->setup->getListThemes();
        $this->cmbTheme->Text=$_SESSION['theme'];
        $this->cmbTheme->DataBind();
    }
    
    public function saveData ($sender,$param) {
        if ($this->IsValid) {
            $theme=$this->cmbTheme->Text;
            $_SESSION['theme']=$theme;
            $userid=$this->Pengguna->getDataUser('userid');
            $str = "UPDATE simak_user SET theme='$theme' WHERE userid=$userid";            
            $this->DB->updateRecord($str);
            $this->redirect('settings.Profiles',true);
        }
    }
    public function saveDataPassword ($sender,$param) {
        if ($this->IsValid) {
            $username=$this->Pengguna->getDataUser('username');
            if ($this->txtPassword->Text != '') {  
                $data=$this->Pengguna->createHashPassword($this->txtPassword->Text);
                $salt=$data['salt'];
                $password=$data['password'];
                $str = "UPDATE user SET userpassword='$password',salt='$salt' WHERE username='$username'";  
                $this->DB->updateRecord($str);
            }
            $this->redirect('settings.Profiles',true);
        }
    }
}