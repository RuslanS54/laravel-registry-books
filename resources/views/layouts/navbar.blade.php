<nav class="navbar navbar-expand-lg navbar-light">

  <div class="container-fluid">
    <a class="navbar-brand" href="/">Реестр книг</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">

      @if( auth()->user() !== null && auth()->user()['role']['id'] === 1 )
        <ul class="navbar-nav ms-auto">
          <div class="btn-group">
            <li class="nav-item dropdown">
              <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdownManage" role="button"
                 data-bs-toggle="dropdown" aria-expanded="false">
                Управление
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownManage">
                <li><a class="dropdown-item" href="/admin/book">Книги</a></li>
                <li><a class="dropdown-item" href="/admin/genre">Жанр</a></li>
                <li><a class="dropdown-item" href="/admin/user">Пользователь</a></li>
              </ul>
            </li>
          </div>
          <div class="btn-group">
                
          <form action="/logout" method="POST">
            @csrf
            <button class="dropdown-item" type="submit">Выйти</button>
          </form>
           
          </div>
        </ul>
      @endif

 
    

    </div>
  </div>
</nav>
