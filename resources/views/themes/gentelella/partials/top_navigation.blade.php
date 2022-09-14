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
              <i class="fa fa-trash fa-lg"></i>
              <span class="badge bg-green" id="count_sampah"></span>
            </a>
            <ul class="dropdown-menu list-unstyled msg_list" id="msg_list" role="menu" aria-labelledby="navbarDropdown1" x-placement="top-start">
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
      var url_notif = "{{ url('transaksi-retribusi-sampah/get-notif') }}";
      $.ajax({
        url: url_notif,
          success: function( response, status, xhr ) {
            $('#count_sampah').html(response.count)
            $.each(response.data , function (key, value) {
                $('#msg_list').append(
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
              $('#msg_list').append(
                  `<li class="nav-item">
                      <div class="text-center">
                        <a class="dropdown-item">
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
            url: url_notif,
            success: function( response, status, xhr ) {
              $('#count_sampah').html(response.count)
              $("#msg_list").html("");
              $.each(response.data , function (key, value) {
                $('#msg_list').append(
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
              $('#msg_list').append(
                  `<li class="nav-item">
                      <div class="text-center">
                        <a class="dropdown-item">
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
  });
  </script>