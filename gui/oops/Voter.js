/**
name
age
gender
dob
epic
aadhaar
mobile
guardian
address
constituency
vote

Voter()
login()
getAadhaarNo()
getEPICNo()
getName()
getDOB()
getGuardianName()
getConstituencyNo()
getMobileNo()
castVote(candidate_ID)
**/

function Voter() {}

Voter.prototype.login = function() {

};

Voter.prototype.getAadhaarNo = function() {
  return this.uid;
};

Voter.prototype.getEPICNo = function() {
  return this.epic;
};

Voter.prototype.getName = function() {
  return this.vname;
};

Voter.prototype.getDOB = function() {
  return this.dob;
};

Voter.prototype.getGuardianName = function() {
  return this.guardian;
};

Voter.prototype.getConstituencyNo = function() {
  return this.constituency;
};

Voter.prototype.getMobileNo = function() {
  return this.mobile;
};

Voter.prototype.castVote = function(candidate) {
  return candidate.getCandidateID();
};
