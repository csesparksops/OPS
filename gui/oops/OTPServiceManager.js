/**
OTPServiceManager(mobile)
generateOTP()
sendOTP(mobile)
authenticateOTP(ueotp)
**/

function OTPServiceManager() {
  this.mobile = '';
  this.uid = '';
}

OTPServiceManager.prototype.generateOTP = function() {
  console.log('In OTPServiceManager:uid-'+this.uid+' mobile-'+this.mobile);
  return this.sendOTP(this.uid, this.mobile);
};

OTPServiceManager.prototype.sendOTP = function(uid, mobile) {
  var x = new XMLHttpRequest();
  var otpstat;
  x.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200)
      otpstat = this.responseText;
  };
  x.open('POST', '/api/aadhaarverification.php', false);
  x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  x.send('uid='+uid+'&mobile='+mobile);
  return otpstat;
};

OTPServiceManager.prototype.authenticateOTP = function(ueotp, finalname) {
  console.log('entering authenticateOTP');
  var x = new XMLHttpRequest();
  var resp;
  x.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200)
      resp = this.responseText;
  };
  x.open('POST', '/api/otprequest.php', false);
  x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  x.send('uid='+this.uid+'&otp='+ueotp+'&name='+finalname);
  console.log(resp);
  return resp;
};
