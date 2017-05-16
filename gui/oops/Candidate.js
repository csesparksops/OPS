/**
name
age
gender
dob
candidate_id
political_party
political_party_symbol
state
constituency

Candidate()
getCandidateID()
getName()
getPoliticalParty()
getPoliticalPartySymbol()
getConstituencyNo()
**/

function Candidate() {}

Candidate.prototype.getCandidateID = function() {
  return this.candidate_id;
};

Candidate.prototype.getName = function() {
  return this.cname;
};

Candidate.prototype.getPoliticalParty = function() {
  return this.political_party;
};

Candidate.prototype.getPoliticalPartySymbol = function() {
  return this.political_party_symbol;
};

Candidate.prototype.getConstituencyNo = function() {
  return this.constituency;
};
