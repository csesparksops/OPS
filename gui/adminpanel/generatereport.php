<?php
session_start();
$_SESSION['Knight'] = 'Warrior against hack-a-tack';
?>
<script src='/extconnect/firebase.js.php'></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div id="donutchart0" style="width: 100%; height: 400px;"></div><hr/>
<script>
console.log('got here');
var report = {0:{0:-1}};
var clist = {0:['Test Candidate', 'None']};
var total = {'None of the above':0};
var chartno = 0;
var vlist = {};


dataset.ref('/candidate').once('value').then(function(candss) {
  candss.forEach(function(candcss) {
    var cand = candcss.key;
    var cons = candcss.val()['constituency'];
    clist[cand] = [candcss.val()['name'], candcss.val()['party']];

    if(report.hasOwnProperty(cons)==false) {
      report[cons] = {};
      vlist[cons] = 0;
      clist['000000000'+String(cons)] = ['NOTA', 'None of the above'];
      report[cons]['000000000'+String(cons)] = 0;
      var elem = document.createElement('div');
      elem.style.width = '100%';
      elem.style.height = '300px';
      chartno++;
      elem.id = 'donutchart'+chartno;
      console.log(elem);
      document.body.appendChild(document.createElement('hr'));
      document.body.appendChild(elem);
    }
    
    report[cons][cand] = 0;
    total[clist[cand][1]] = 0;
    
  });
  
  
  dataset.ref('/voter').once('value').then(function(vss) {
   vss.forEach(function(vcss) {
     var votercons = vcss.val()['constituency'];
     if (votercons in vlist) {
       vlist[votercons] += 1;
     }
   });
  var totalvoters = 0;
  for(var cnsttnc in vlist)
    totalvoters += vlist[cnsttnc];
  
  dataset.ref('/vote').once('value').then(function(votess) {
    votess.forEach(function(votecss) {
      var vcons = votecss.val()['constituency'];
      var vcand = votecss.val()['candidate'];
      report[vcons][vcand] += 1;
      total[clist[vcand][1]] += 1;
    });
    console.log('totalvoters: '+ totalvoters);
    console.log(vlist);
    google.charts.load("current", {packages:["corechart"]});
    
    var tarr = [['Political party', 'Number of votes']];
    
    delete total['None'];
    console.log(total);
    var voted = 0;
    var notas = 0;
    for (var i in total) {
      voted += total[i];
      if (i == 'None of the above')
        continue;
      tarr.push([i, total[i]]);
    }
    tarr.push(['None of the above', total['None of the above']]);
    tarr.push(['Not voted', totalvoters-voted]);
    console.log('tarr:'+tarr);
    google.charts.setOnLoadCallback(function () {
      var data = google.visualization.arrayToDataTable(tarr);
      var options = {
        title: 'Overall Result',
        is3D: true,
        sliceVisibilityThreshold: 0
      };
      var chart = new google.visualization.PieChart(document.getElementById('donutchart0'));
      chart.draw(data, options);
    });
    delete report[0];
    console.log(report);
    console.log('getting inside chart loop');
    var carr = {};
    for (var i in report) {
      carr[i] = [['Political party', 'Number of votes']];
      for (var j in report[i]) {
        vlist[i] -= report[i][j];
        if (clist[j][0] == 'NOTA')
          continue;
        carr[i].push([clist[j][0]+' ('+clist[j][1]+')', report[i][j]]);
      }
      console.log('vlist('+i+'): '+vlist[i]);
      carr[i].push(['NOTA (None of the above)', report[i]['000000000'+String(i)]]);
      carr[i].push(['Not voted', vlist[i]]);
      console.log(carr);
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(function (x) {
        //console.log(carr[i]);
        var data = google.visualization.arrayToDataTable(carr[x]);
        
        var options = {
          title: 'Constituency: ' + x,
          is3D: true,
          sliceVisibilityThreshold: 0
        };
        console.log(options);
        var delem = document.getElementById('donutchart'+chartno);
        chartno--;
        console.log(delem);
       
        var chart = new google.visualization.PieChart(delem);
        chart.draw(data, options);
      }.bind(this, i));
    }
  });
});
});
</script>
