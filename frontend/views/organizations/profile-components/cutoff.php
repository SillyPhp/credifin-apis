<?php
?>
<div class="container cutoff">
    <div class="row">
        <div class='col-md-12 cutoff-table'>
            <table>
                <thead>
                <tr>
                    <th>Course Name</th>
                    <th>General</th>
                    <th>SC</th>
                    <th>ST</th>
                    <th>OBC</th>
                    <th>PWD</th>
                    <th>EWS</th>
                </tr>
                </thead>
                <tbody class="cutoff-data">

                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$this->registerCSS('

.cutoff-table{
  overflow: auto;
}
.cutoff h1{
  font-family: Roboto;
  font-weight: 700;
  color: #00A0E3;
  font-size: 28pt;
  margin-bottom: 20px;
}
.cutoff-table table{
  min-width: 600px;
  width: 100%;
}
.cutoff-table table tbody tr:nth-child(2n-1) {
  background: #DAE9FF;
}
.cutoff-table table tr {
  background: #fff;
  box-shadow: 1px 0 4px 0 #c3c3c3;
}
.cutoff-table table td, table th {
  padding: 10px;
}
');
?>
<script>
    async function getCutoff(){
        let response = await fetch(`${baseUrl}/api/v3/ey-college-profile/cut-off`, {
          method: 'POST',
          body: data,
        })
        let res = await response.json();

        if(res['response']['status'] == 200){
            createCutoffRow(res['response']['cutoff']);
        }else{
            document.querySelector('.cutoff-table').innerHTML = noDetailsFound();
        }
    }
    getCutoff();

    function createCutoffRow(cutoffs){
        let cutoffRow = cutoffs.map(cutoff => {
            let mode = cutoff.mode == 0 ? 'Percentage' : 'Percentile'
            return `<tr>
                        <td>${cutoff.course_name}</td>
                        <td>${cutoff.general} ${mode}</td>
                        <td>${cutoff.sc} ${mode}</td>
                        <td>${cutoff.st} ${mode}</td>
                        <td>${cutoff.obc} ${mode}</td>
                        <td>${cutoff.pwd} ${mode}</td>
                        <td>${cutoff.ews} ${mode}</td>
                    </tr>`
        }).join('');

        document.querySelector('.cutoff-data').innerHTML = cutoffRow;
    }

</script>
