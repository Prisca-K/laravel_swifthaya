<x-guest-layout>
  <h1>Swifthaya: A dynamic freelancing platform connecting
    freelancers with clients.</h1>
  <h2>Login to Explore</h2>
  {{-- message --}}
  <div
    style="width:100%; margin-top:1rem; display:flex; gap:1rem; justify-content:center;align-items:center;">
    <a style="border: 2px solid blue; padding:0.5rem; min-width:5rem"
      href="{{Route("login")}}">Login</a>
    <a style="border: 2px solid blue; padding:0.5rem; min-width:5rem"
      href="{{Route("register")}}">Register</a>
  </div>
</x-guest-layout>