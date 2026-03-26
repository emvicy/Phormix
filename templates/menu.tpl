{* @see https://getbootstrap.com/docs/5.3/components/navbar/ *}
<nav class="navbar navbar-expand-lg fixed-top bg-white shadow">
    <div class="container position-relative">
        <a class="navbar-brand" href="{href('home')}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="go back to primary module">
            {MVC\Config::get_MVC_MODULE_PRIMARY_NAME()}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">

            <!--menu-->
            {App\Model\Menu::get('frontend')}

        </div>
    </div>
</nav>
