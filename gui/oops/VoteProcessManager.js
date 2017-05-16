/**
candidateObject
dbManagerObject
voteObject
voterObject

voteProcessManager()
voteProcessManager(Constituency)
listCandidate(constituency)
saveVotes(vote)
countVotes()
**/

function VoteProcessManager() {}

VoteProcessManager.prototype.listCandidate = function(candidate) {
  this.ccount = this.ccount + 1;
  console.log('in manager: ccount-'+this.ccount+' name-'+candidate.cname+' party-'+candidate.political_party+' symbol-'+candidate.political_party_symbol);
  var x = new XMLHttpRequest();
  var resp;
  x.onreadystatechange = function() {
    if (x.readyState == 4 && x.status == 200)
      resp = this.responseText;
  };
  x.open('POST', '/api/candidatelist.php', false);
  x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  x.send('sl='+this.ccount+'&name='+candidate.cname+'&party='+candidate.political_party+'&symbol='+candidate.political_party_symbol);
  return resp;
};

VoteProcessManager.prototype.saveVotes = function(vote) {
  console.log('entering savevotes');
  var x = new XMLHttpRequest();
  var resp;
  x.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200)
      resp = this.responseText;
  };
  x.open('POST', '/api/castvote.php', false);
  x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  x.send('cid='+vote.getCandidateNo());
  console.log('display'+resp);
  return resp;
};

VoteProcessManager.prototype.countVotes = function() {

};
