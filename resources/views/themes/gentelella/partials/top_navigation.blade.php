<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
      <nav>
        <div class="nav toggle">
          <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>

        <ul class="nav navbar-nav navbar-right">
          <li class="">
            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <img src="{{ url('themes/AdminLTE-2.4.3/dist/img/user2-160x160.jpg') }}" alt="">{{ Helpers::getNama() }}
              <span class=" fa fa-angle-down"></span>
            </a>
            <ul class="dropdown-menu dropdown-usermenu pull-right">
              <li>
                <a href="" title="Keluar" data-toggle="modal" data-target="#modalLogout" data-id="{{ Helpers::getId() }}">
                  {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ url('logout') }}" method="POST" class="d-none">

                </form>
              </li>
            </ul>
          </li>
          @if(Helpers::getJabatan() == 'Direktur')
          <li role="presentation" class="nav-item dropdown">
            <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-truck fa-lg"></i>
              <span class="badge bg-green" id="count_samsat"></span>
            </a>
            <ul class="dropdown-menu list-unstyled msg_list" id="msg_list_samsat" role="menu" aria-labelledby="navbarDropdown1" x-placement="top-start">
                {{-- data from ajax --}}

            </ul>
          </li>
          <li role="presentation" class="nav-item dropdown">
            <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-trash fa-lg"></i>
              <span class="badge bg-green" id="count_sampah"></span>
            </a>
            <ul class="dropdown-menu list-unstyled msg_list" id="msg_list_sampah" role="menu" aria-labelledby="navbarDropdown1" x-placement="top-start">
                {{-- data from ajax --}}

            </ul>
          </li>
          <li role="presentation" class="nav-item dropdown">
            <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-cc-mastercard fa-lg"></i>
              <span class="badge bg-green" id="count_online"></span>
            </a>
            <ul class="dropdown-menu list-unstyled msg_list" id="msg_list_online" role="menu" aria-labelledby="navbarDropdown1" x-placement="top-start">
                {{-- data from ajax --}}

            </ul>
          </li>
          @endif
        </ul>
      </nav>
    </div>
  </div>
  <!-- /top navigation -->

  
  
  <!-- MODAL LOGOUT -->
  @include('modal.header.modal_logout')

  <script>
    $(document).ready(function(){
      // SAMPAH
      var url_notif_sampah = "{{ url('transaksi-retribusi-sampah/get-notif') }}";
      $.ajax({
        url: url_notif_sampah,
          success: function( response, status, xhr ) {
            $('#count_sampah').html(response.count)
            $.each(response.data , function (key, value) {
                $('#msg_list_sampah').append(
                  `<li class="nav-item">
                    <a href="{{ url('transaksi-retribusi-sampah/validasi-perubahan/${value.id}') }}" class="dropdown-item">
                      <span>
                        <span>${value.nama_user}</span>
                        <span class="time">${value.date_human}</span>
                      </span><br>
                      <span class="message">
                        Terdapat perubahan transaksi sampah dengan kode transaksi <b>${value.kode_transaksi_sampah}</b>
                      </span>
                    </a>
                  </li>`
                );
              });
              $('#msg_list_sampah').append(
                  `<li class="nav-item">
                      <div class="text-center">
                        <a href="{{ url('transaksi-retribusi-sampah/semua-perubahan') }}" class="dropdown-item">
                          <strong>Lihat semua perubahan transaksi sampah</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>`
                  );
          },
      });
      setInterval(function(){
          $.ajax({
            url: url_notif_sampah,
            success: function( response, status, xhr ) {
              $('#count_sampah').html(response.count)
              $("#msg_list_sampah").html("");
              $.each(response.data , function (key, value) {
                $('#msg_list_sampah').append(
                  `<li class="nav-item">
                    <a href="{{ url('transaksi-retribusi-sampah/validasi-perubahan/${value.id}') }}" class="dropdown-item">
                      <span>
                        <span>${value.nama_user}</span>
                        <span class="time">${value.date_human}</span>
                      </span><br>
                      <span class="message">
                        Terdapat perubahan transaksi sampah dengan kode transaksi <b>${value.kode_transaksi_sampah}</b>
                      </span>
                    </a>
                  </li>`
                );

              });
              $('#msg_list_sampah').append(
                  `<li class="nav-item">
                      <div class="text-center">
                        <a href="{{ url('transaksi-retribusi-sampah/semua-perubahan') }}" class="dropdown-item">
                          <strong>Lihat semua perubahan transaksi sampah</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>`
                  );
            },
            error: function(error)
            {
              $.alert_error(error);
              return false
            }
          });
      }, 20000);

      //SAMSAT
      var url_notif_samsat = "{{ url('transaksi-samsat-kendaraan/get-notif') }}";
      $.ajax({
        url: url_notif_samsat,
          success: function( response, status, xhr ) {
            $('#count_samsat').html(response.count)
            $.each(response.data , function (key, value) {
                $('#msg_list_samsat').append(
                  `<li class="nav-item">
                    <a href="{{ url('transaksi-samsat-kendaraan/validasi-perubahan/${value.id}') }}" class="dropdown-item">
                      <span>
                        <span>${value.nama_user}</span>
                        <span class="time">${value.date_human}</span>
                      </span><br>
                      <span class="message">
                        Terdapat perubahan transaksi samsat kendaraan dengan kode transaksi <b>${value.kode_transaksi_samsat}</b>
                      </span>
                    </a>
                  </li>`
                );
              });
              $('#msg_list_samsat').append(
                  `<li class="nav-item">
                      <div class="text-center">
                        <a href="{{ url('transaksi-samsat-kendaraan/semua-perubahan') }}" class="dropdown-item">
                          <strong>Lihat semua perubahan transaksi samsat</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>`
                  );
          },
      });
      setInterval(function(){
          $.ajax({
            url: url_notif_samsat,
            success: function( response, status, xhr ) {
              $('#count_samsat').html(response.count)
              $("#msg_list_samsat").html("");
              $.each(response.data , function (key, value) {
                $('#msg_list_samsat').append(
                  `<li class="nav-item">
                    <a href="{{ url('transaksi-samsat-kendaraan/validasi-perubahan/${value.id}') }}" class="dropdown-item">
                      <span>
                        <span>${value.nama_user}</span>
                        <span class="time">${value.date_human}</span>
                      </span><br>
                      <span class="message">
                        Terdapat perubahan transaksi samsat dengan kode transaksi <b>${value.kode_transaksi_samsat}</b>
                      </span>
                    </a>
                  </li>`
                );

              });
              $('#msg_list_samsat').append(
                  `<li class="nav-item">
                      <div class="text-center">
                        <a href="{{ url('transaksi-samsat-kendaraan/semua-perubahan') }}" class="dropdown-item">
                          <strong>Lihat semua perubahan transaksi samsat</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>`
                  );
            },
            error: function(error)
            {
              $.alert_error(error);
              return false
            }
          });
      }, 20000);

      //TRANSAKSI ONLINE
      var url_notif_online = "{{ url('transaksi-pembayaran-online/get-notif') }}";
      $.ajax({
        url: url_notif_online,
          success: function( response, status, xhr ) {
            $('#count_online').html(response.count)
            $.each(response.data , function (key, value) {
                $('#msg_list_online').append(
                  `<li class="nav-item">
                    <a href="{{ url('transaksi-pembayaran-online/validasi-perubahan/${value.id}') }}" class="dropdown-item">
                      <span>
                        <span>${value.nama_user}</span>
                        <span class="time">${value.date_human}</span>
                      </span><br>
                      <span class="message">
                        Terdapat perubahan transaksi pembayaran online dengan kode transaksi <b>${value.kode_transaksi_online}</b>
                      </span>
                    </a>
                  </li>`
                );
              });
              $('#msg_list_online').append(
                  `<li class="nav-item">
                      <div class="text-center">
                        <a href="{{ url('transaksi-pembayaran-online/semua-perubahan') }}" class="dropdown-item">
                          <strong>Lihat semua perubahan transaksi online</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>`
                  );
          },
      });
      setInterval(function(){
          $.ajax({
            url: url_notif_online,
            success: function( response, status, xhr ) {
              $('#count_online').html(response.count)
              $("#msg_list_online").html("");
              $.each(response.data , function (key, value) {
                $('#msg_list_online').append(
                  `<li class="nav-item">
                    <a href="{{ url('transaksi-pembayaran-online/validasi-perubahan/${value.id}') }}" class="dropdown-item">
                      <span>
                        <span>${value.nama_user}</span>
                        <span class="time">${value.date_human}</span>
                      </span><br>
                      <span class="message">
                        Terdapat perubahan transaksi online dengan kode transaksi <b>${value.kode_transaksi_online}</b>
                      </span>
                    </a>
                  </li>`
                );

              });
              $('#msg_list_online').append(
                  `<li class="nav-item">
                      <div class="text-center">
                        <a href="{{ url('transaksi-pembayaran-online/semua-perubahan') }}" class="dropdown-item">
                          <strong>Lihat semua perubahan transaksi online</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>`
                  );
            },
            error: function(error)
            {
              $.alert_error(error);
              return false
            }
          });
      }, 20000);
  });
  </script>