/**
username
password
voteProcessManagerObject

displayResults()
getUsername()
getPassword()
**/

function Admin(username, password, voteProcessManagerObject) {
  this.username = username;
  this.password = password;
  this.voteProcessManagerObject = voteProcessManagerObject;
}

Admin.prototype.displayResults = function() {
  
};

Admin.prototype.getUsername = function() {
  return this.username;
};

Admin.prototype.getPassword = function() {
  return this.password;
};
