/**
aadhaar
epic
constituency
candidate
timestamp
ip_address

Vote(candidate_id, ip_address, timestamp)
getAadhaarNo()
setAadhaarNo(aadhaar)
getEPICNo()
setEPICNo(EPIC)
getConstituencyNo()
setConstituencyNo(constituency)
getCandidateNo()
setCandidateNo(candidate)
getTimestamp()
setTimestamp(timestamp)
getIPAddress()
setIPAddress(ip_address)
**/

function Vote(){
}

Vote.prototype.getAadhaarNo = function() {
  return this.aadhaar;
};

Vote.prototype.setAadhaarNo = function(aadhaar) {
  this.aadhaar = aadhaar;
};

Vote.prototype.getEPICNo = function() {
  return this.epic;
};

Vote.prototype.setEPICNo = function(epic) {
  this.epic = epic;
};

Vote.prototype.getConstituencyNo = function() {
  return this.constituency;
};

Vote.prototype.setConstituencyNo = function(constituency) {
  this.constituency = constituency;
};

Vote.prototype.getCandidateNo = function() {
  return this.candidate;
};

Vote.prototype.setCandidateNo = function(candidate) {
  this.candidate = candidate;
};

Vote.prototype.getTimestamp = function() {
  return this.timestamp;
};

Vote.prototype.setTimestamp = function(timestamp) {
  this.timestamp = timestamp;
};

Vote.prototype.getIPAddress = function() {
  return this.ip_ddress;
};

Vote.prototype.setIPAddress = function(ip_address) {
  this.ip_address = ip_address;
};
