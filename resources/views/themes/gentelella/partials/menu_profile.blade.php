
<!-- menu profile quick info -->
<div class="profile clearfix">
    <div class="profile_pic">
        <img src="{{ url('themes/default/images/user2-160x160.jpg') }}" alt="..." class="img-circle profile_img">
    </div>
    <div class="profile_info">
        <span>Halo, {{ Helpers::getJabatan() }}</span>
        <h2>{{ Helpers::getNama() }}</h2>
    </div>
</div>
<!-- /menu profile quick info -->