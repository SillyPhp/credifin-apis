<?php

use yii\helpers\url;

?>

<div class="container cutoff">
  <div class="row">
    <div class="col-md-12">
      <h1>CutOff</h1>
    </div>
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
        <tbody>
          <tr>
            <td>B.Tech</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
          </tr>
          <tr>
            <td>B.Tech</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
          </tr>
          <tr>
            <td>B.Tech</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
          </tr>
          <tr>
            <td>B.Tech</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
          </tr>
          <tr>
            <td>B.Tech</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
          </tr>
          <tr>
            <td>B.Tech</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
            <td>50%</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php
$this->registerCss('
.title{
  animation: translate 2s ease;
}
.text{
  font-size: 16px;
  margin:15px 0 5px 0px;
  animation: text 2s ease;
}
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
table{
  min-width: 600px;
  width: 100%;
}
table tbody tr:nth-child(2n-1) {
  background: #DAE9FF;
}
table tr {
  background: #fff;
  box-shadow: 1px 0 4px 0 #c3c3c3;
}
table td, table th {
  padding: 10px;
}
');
