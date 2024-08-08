<section class="space-y-6">
  <header>
    <h2
      class="text-lg font-medium text-gray-900 dark:text-gray-100">
      {{ __('Add profile Photo') }}
    </h2>

    <p
      class="mt-1 text-sm text-gray-600 dark:text-gray-400">
      {{ __('Photo must be less than 2048MB. jpeg, webp ,
      svg, png and gif only') }}
    </p>
  </header>
  <style>
    .img-cont {
      position: relative;
      width: 50px;
      height: 50px;
      margin: 3rem;
      border-radius: 50%;
      background-color: rgba(182, 181, 181, 0.603);
    }

    i {
      position: absolute;
      font-size: 8rem;
      top: 50%;
      left: 50%;
      z-index: 77;
      border-radius: 50%;
      transform: translate(-50%, -50%);
      background-color: grey;
    }

    .addimg .img {
      position: absolute;
      width: 150px;
      height: 150px;
      border: 2px solid grey;
      top: 50%;
      left: 50%;
      z-index: 99;
      border-radius: 50%;
      transform: translate(-50%, -50%);
    }
    .addimg .img img{
      object-fit: cover;
      object-position: top;
      width: 100%;
      height: 100%;
      border-radius: 50%;
    }
    .addimg {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      flex-direction: column;
      gap: 2rem;

    }

    .img_input {
      border: 1.5px solid grey !important;
      padding: 5px;
      border-radius: 5px;
    }
  </style>
  <form class="addimg" enctype="multipart/form-data"
    method="post" action="{{Route("profile.addimg",
    $profile->id)}}">
    @csrf
    <div class="img-cont">
      <i class="ph ph-user-circle"></i>
      <div class="img">
        <img src="{{$profile->getImgUrl()}}"
          alt="profile image">
      </div>
    </div>
    <input class="img_input" type="file"
      name="profile_picture" id="profile_picture">
    @error('profile_picture')
    <p>{{$message}}</p>
    @enderror
    <x-primary-button>
      Add profile image
    </x-primary-button>
  </form>

</section>