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
                      <li id="now"><a href='#'>DownLoad</a></li>
                      <li><a href="/taxonomy">Taxonomy</a></li>
                      <li><a href='/help'> Help </a></li>
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
                                  <td class="DL_fasta">
                                    <a href="{{ route('download.index','ALL_Viridiplantae.zip') }}">FASTA</a>
                                  <td class="DL_tax">
                                    <a href="{{ route('download.index','All_Viridiplantae_taxidList.zip') }}">TaxonomyList</a>
                                  <td>2019/9/16</td>
                              </tr>
                              <tr>
                                  <th>Curated DB (<span> 5 </span>sites)</th>
                                  <td>33,602</td>
                                  <td class="DL_fasta">
                                    <a href="{{ route('download.index','Viridiplantae_5sites.zip"') }}">FASTA</a>
                                  <td class="DL_tax">
                                    <a href="{{ route('download.index','Viridiplantae_5sites_taxidList.zip') }}">TaxonomyList</a>
                                  <td>2019/9/16</td>
                              </tr>
                              <tr>
                                  <th>Curated DB (<span> 3 </span>sites)</th>
                                  <td>12,785</td>
                                  <td class="DL_fasta">
                                    <a href="{{ route('download.index','Viridiplantae_3sites.zip') }}">FASTA</a>
                                  <td class="DL_tax">
                                    <a href="{{ route('download.index','Viridiplantae_3sites_taxidList.zip') }}">TaxonomyList</a>
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
                                  <td class="DL_fasta">
                                    <a href="{{ route('download.index','All_Other.zip') }}">FASTA</a>
                                  </td>
                                  <td class="DL_tax">
                                    <a href="{{ route('download.index','All_Other_taxidList.zip') }}">TaxonomyList</a></td>
                                  <td>2019/9/16</td>
                              </tr>
                              <tr>
                                  <th>Curated DB (<span> 5 </span>sites)</th>
                                  <td>6,769</td>
                                  <td class="DL_fasta">
                                    <a href="{{ route('download.index','Other_5sites.zip') }}">FASTA</a></td>
                                  <td class="DL_tax">
                                    <a href="{{ route('download.index','Other_5sites_taxidList.zip') }}">TaxonomyList</a></td>
                                  <td>2019/9/16</td>
                              </tr>
                              <tr>
                                  <th>Curated DB (<span> 3 </span>sites)</th>
                                  <td>3,737</td>
                                  <td class="DL_fasta">
                                    <a href="{{ route('download.index','Other_3sites.zip') }}">FASTA</a></td>
                                  <td class="DL_tax">
                                    <a href="{{ route('download.index','Other_3sites_taxidList.zip') }}">TaxonomyList</a></td>
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