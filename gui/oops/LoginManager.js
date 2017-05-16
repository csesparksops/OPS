/**
OTPManagerOBject
dbManagerOBject
adminObject
voterObject
voteProcessManagerObject

LoginManager()
voterLogin()
adminLogin()
checkValidity(uid)
linkAadhaar(epic, uid)
logout()
**/

function LoginManager() {
  this.OTPManagerObject = '';
  this.dbManagerObject = '';
  this.adminObject = '';
  this.voterObject = '';
  this.voteProcessManagerObject = '';
}

LoginManager.prototype.voterLogin = function() {
  var x = new XMLHttpRequest();
  x.open('GET', '/api/voterlogin.php', false);
  x.send();
  window.location.replace('http://uidai-gov.96.lt/epoll/main.php');
};

LoginManager.prototype.adminLogin = function() {

};

LoginManager.prototype.checkValidity = function(uid) {
  var x = new XMLHttpRequest();
  var resp;
  x.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200)
      resp = this.responseText;
  };
  x.open('POST', '/api/voterequest.php', false);
  x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  x.send('uid='+uid);
  return resp; 
};

LoginManager.prototype.matchAadhaar = function() {
  var resp;
  var x = new XMLHttpRequest();
  x.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200)
      resp = this.responseText;
  };
  x.open('POST', '/api/matchid.php', false);
  x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  x.send('epic='+this.voterObject.epic);
  return resp;
};

LoginManager.prototype.linkAadhaar = function() {
  var resp;
  var x = new XMLHttpRequest();
  x.onreadystatechange = function() {
    if(this.readyState == 4 && this.status == 200)
      resp = this.responseText;
  };
  x.open('POST', '/api/linkid.php', false);
  x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  x.send('uname='+this.voterObject.uname+'&ename='+this.voterObject.ename+'&uguardian='+this.voterObject.uguardian+'&eguardian='+this.voterObject.eguardian+'&udob='+this.voterObject.udob+'&edob='+this.voterObject.edob);
  return resp;
};

LoginManager.prototype.logout = function() {
  var x = new XMLHttpRequest();
  x.open('GET', '/api/resetsession.php', false);
  x.send();
};
