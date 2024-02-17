@extends('layouts.layout')

@section('append_header')
  <link rel='stylesheet' href='/css/download.css'>
@endsection

@section('headerContent')
  <header>
      <div class="header-inner">
          <div class="Logo">Barcode DB</div>
          <div class="header-item">
              <nav class="nav1">
                  <ul>
                      <li><a href="/"> Top </a></li>
                      <li><a href="/download">DownLoad</a></li>
                      <li><a href="/taxonomy">Taxonomy</a></li>
                      <li id="now"><a href='#'> Help </a></li>
                  </ul>
              </nav>
          </div>
      </div>
  </header>
  <h1 style="font-family:Century">DownLoad</h1>
  <main>
      <div class="main">
          <div class="main_wrapper">
              <h2>rbcL <span class="rbcL"><br>(ribulose 1,5-bisphosphatecarboxylase/oxygenase large subunit)</span>
              </h2>
              <div class="table_wrap">
                  <div class="tit1">
                      <table>
                          <caption>Viridiplantae</caption>
                          <tbody>
                              <tr class="head">
                                  <th>Database</th>
                                  <th>Total sequences</th>
                                  <th>Download</th>
                                  <th>Download</th>
                                  <th>Last Update</th>
                              </tr>
                              <tr>
                                  <th>ALL (redundant)</th>
                                  <td>167,033</td>
                                  <td class="DL_fasta"><a
                                          href="../resources/downLoad/gz_fasta/ALL_Viridiplantae.zip">FASTA</a></td>
                                  <td class="DL_tax"><a
                                          href="../resources/downLoad/gz_taxidList/All_Viridiplantae_taxidList.zip">Taxonomy
                                          List</a></td>
                                  <td>2019/9/16</td>
                              </tr>
                              <tr>
                                  <th>Curated DB (<span> 5 </span>sites)</th>
                                  <td>33,602</td>
                                  <td class="DL_fasta"><a
                                          href="../resources/downLoad/gz_fasta/Viridiplantae_5sites.zip">FASTA</a></td>
                                  <td class="DL_tax"><a
                                          href="../resources/downLoad/gz_taxidList/Viridiplantae_5sites_taxidList.zip">Taxonomy
                                          List</a></td>
                                  <td>2019/9/16</td>
                              </tr>
                              <tr>
                                  <th>Curated DB (<span> 3 </span>sites)</th>
                                  <td>12,785</td>
                                  <td class="DL_fasta"><a
                                          href="../resources/downLoad/gz_fasta/Viridiplantae_3sites.zip">FASTA</a></td>
                                  <td class="DL_tax"><a
                                          href="../resources/downLoad/gz_taxidList/Viridiplantae_3sites_taxidList.zip">Taxonomy
                                          List</a></td>
                                  <td>2019/9/16</td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
                  <div class="tit2">
                      <table>
                          <caption>Others</caption>
                          <tbody>
                              <tr class="head">
                                  <th>Database</th>
                                  <th>Total sequences</th>
                                  <th>Download</th>
                                  <th>Download</th>
                                  <th>Last Update</th>
                              </tr>
                              <tr>
                                  <th>ALL (redundant)</th>
                                  <td>23,008</td>
                                  <td class="DL_fasta"><a href="../resources/downLoad/gz_fasta/ALL_Other.zip">FASTA</a>
                                  </td>
                                  <td class="DL_tax"><a
                                          href="../resources/downLoad/gz_taxidList/All_Other_taxidList.zip">Taxonomy
                                          List</a></td>
                                  <td>2019/9/16</td>
                              </tr>
                              <tr>
                                  <th>Curated DB (<span> 5 </span>sites)</th>
                                  <td>6,769</td>
                                  <td class="DL_fasta"><a
                                          href="../resources/downLoad/gz_fasta/Other_5sites.zip">FASTA</a></td>
                                  <td class="DL_tax"><a
                                          href="../resources/downLoad/gz_taxidList/Other_5sites_taxidList.zip">Taxonomy
                                          List</a></td>
                                  <td>2019/9/16</td>
                              </tr>
                              <tr>
                                  <th>Curated DB (<span> 3 </span>sites)</th>
                                  <td>3,737</td>
                                  <td class="DL_fasta"><a
                                          href="../resources/downLoad/gz_fasta/Other_3sites.zip">FASTA</a></td>
                                  <td class="DL_tax"><a
                                          href="../resources/downLoad/gz_taxidList/Other_3sites_taxidList.zip">Taxonomy
                                          List</a></td>
                                  <td>2019/9/16</td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </main>
@endsection

</html>