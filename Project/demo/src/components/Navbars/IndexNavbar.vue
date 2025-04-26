<template>
  <!-- Navbar -->
  <nav class="absolute top-0 left-0 w-full z-10 bg-[#0559fe] md:flex-row md:flex-nowrap md:justify-start flex items-center p-4 pt-0">
    <div class="w-full mx-auto items-center flex justify-between md:flex-nowrap flex-wrap md:px-10 px-4">
      <!-- Brand -->
      <div class="flex items-center">
        <img src="../../assets/logod.png" alt="SmartHR Logo" class="w-[150px] h-auto mr-2" style="width: 156px;"/> <!-- Adjust width and height as needed -->
      </div>

      <!-- User -->
      <ul class="flex-col md:flex-row list-none items-center hidden md:flex gap-4">
        <!-- Book a Demo button -->
        <li class="nav-item">
          <a
            href="#"
            @click="checkout"
            class="text-white font-bold px-4 py-2 rounded-md mr-4 bg-emerald-500 hover:bg-emerald-600 transition duration-200"
          >
            Book a Demo
          </a>
        </li>

        <!-- Login button -->
        <li class="nav-item ml-4">
          <a
            href="/login"
            class="text-white font-bold px-4 py-2 rounded-md bg-blueGray-700 hover:bg-blueGray-600 transition duration-200"
          >
            Login
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- End Navbar -->
</template>

<script>
export default {
  name: "IndexNavbar",
  props: [
    "checkout"
  ],
  
};
</script>
