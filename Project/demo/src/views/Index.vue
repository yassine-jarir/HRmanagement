<template>
  <div>
    <index-navbar :checkout="checkout" />
    <section class="header relative pt-16 items-center flex h-screen max-h-860-px overflow-hidden">
  <div class="container mx-auto flex flex-wrap items-center relative z-10">
    <div class="w-full md:w-8/12 lg:w-6/12 xl:w-6/12 px-4">
      <div class="pt-32 sm:pt-0">
        <h2 class="font-semibold text-4xl text-blueGray-600 animate-fadeInUp">
          HR Management Dashboard - Streamline Your Workforce
        </h2>
        <p class="mt-4 text-lg leading-relaxed text-blueGray-500 animate-fadeInUp delay-200">
          Our HR management system provides you with powerful tools to efficiently manage employee data, track performance, and streamline HR processes. From onboarding to performance reviews, this dashboard covers it all.
        </p>
        <div class="mt-12 flex space-x-4 animate-fadeInUp delay-400">
          <a
            href="#"
            @click="checkout"
            class="get-started text-white font-bold px-6 py-4 rounded outline-none focus:outline-none bg-emerald-500 active:bg-emerald-600 uppercase text-sm shadow hover:shadow-lg ease-linear transition-all duration-150"
          >
            Start Managing Your HR System
          </a>
          <a
            href="https://github.com/yassine-jarir/HRmanagement"
            class="github-star text-white font-bold px-6 py-4 rounded outline-none focus:outline-none bg-blueGray-700 active:bg-blueGray-600 uppercase text-sm shadow hover:shadow-lg ease-linear transition-all duration-150"
            target="_blank"
          >
            GitHub Reposiatory
          </a>
        </div>
      </div>
    </div>

    <!-- <div class="hidden md:block md:w-4/12 lg:w-6/12 xl:w-6/12 px-4 animate-slideInRight">
      <div class="relative group overflow-hidden rounded-lg shadow-2xl">
        <img src="../assets/dashboardDemo.png" alt="dashboard demo" class="w-full h-auto transform transition-transform duration-500 group-hover:scale-110 group-hover:rotate-1" />
      </div>
    </div> -->
  </div>

  <img
    class="absolute top-0 right-0 w-10/12 sm:w-6/12 max-h-860-px opacity-30 animate-fadeIn"
    :src="patternVue"
    alt="HR Dashboard Preview"
  />
</section>

    <section class="mt-48 md:mt-40 pb-40 relative bg-blueGray-100">
      <div class="-mt-20 top-0 bottom-auto left-0 right-0 w-full absolute h-20" style="transform: translateZ(0);">
        <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
          <polygon class="text-blueGray-100 fill-current" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
      <div class="container mx-auto">
        <div class="flex flex-wrap items-center">
          <div class="w-10/12 md:w-6/12 lg:w-4/12 px-12 md:px-4 mr-auto ml-auto -mt-32">
  <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded-lg bg-emerald-500 overflow-hidden">
    <div class="overflow-hidden">
      <img
        alt="HR Management"
        src="../assets/payroll.png"
        class="w-full align-middle rounded-t-lg transform transition-transform duration-500 hover:scale-110"
      />
    </div>
    <blockquote class="relative p-8 mb-4">
      <svg
        preserveAspectRatio="none"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 583 95"
        class="absolute left-0 w-full block h-95-px -top-94-px"
      >
        <polygon points="-30,95 583,95 583,65" class="text-emerald-500 fill-current"></polygon>
      </svg>
      <h4 class="text-xl font-bold text-white">
        Empower Your HR Team with Real-Time Insights
      </h4>
      <p class="text-md font-light mt-2 text-white">
        With our HR management system, you can seamlessly track employee performance, streamline workflows, and automate HR tasks to improve overall efficiency.
      </p>
    </blockquote>
  </div>
</div>


          <div class="w-full md:w-6/12 px-4">
            <div class="flex flex-wrap">
              <div class="w-full md:w-6/12 px-4">
                <div class="relative flex flex-col mt-4">
                  <div class="px-4 py-5 flex-auto">
                    <div class="text-blueGray-500 p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-white">
                      <i class="fas fa-users"></i>
                    </div>
                    <h6 class="text-xl mb-1 font-semibold">Employee Management</h6>
                    <p class="mb-4 text-blueGray-500">
                      Effortlessly manage employee records, track their progress, and oversee their work-life cycle from hiring to retirement.
                    </p>
                  </div>
                </div>
                <div class="relative flex flex-col min-w-0">
                  <div class="px-4 py-5 flex-auto">
                    <div class="text-blueGray-500 p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-white">
                      <i class="fas fa-chart-line"></i>
                    </div>
                    <h6 class="text-xl mb-1 font-semibold">Performance Analytics</h6>
                    <p class="mb-4 text-blueGray-500">
                      Analyze and assess employee performance, track goals, and generate insightful reports for better decision-making.
                    </p>
                  </div>
                </div>
              </div>
              <div class="w-full md:w-6/12 px-4">
                <div class="relative flex flex-col min-w-0 mt-4">
                  <div class="px-4 py-5 flex-auto">
                    <div class="text-blueGray-500 p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-white">
                      <i class="fas fa-cogs"></i>
                    </div>
                    <h6 class="text-xl mb-1 font-semibold">Automated Workflows</h6>
                    <p class="mb-4 text-blueGray-500">
                      Automate tedious HR tasks such as employee onboarding, leave management, and payroll processing to save time and effort.
                    </p>
                  </div>
                </div>
                <div class="relative flex flex-col min-w-0">
                  <div class="px-4 py-5 flex-auto">
                    <div class="text-blueGray-500 p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-white">
                      <i class="fas fa-file-alt"></i>
                    </div>
                    <h6 class="text-xl mb-1 font-semibold">HR Documentation</h6>
                    <p class="mb-4 text-blueGray-500">
                      Easily manage HR-related documents, contracts, and policies in one secure, centralized location.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="container mx-auto overflow-hidden pb-20">
        <div class="flex flex-wrap items-center">
          <div class="w-full md:w-4/12 px-12 md:px-4 ml-auto mr-auto mt-48">
            <div class="text-blueGray-500 p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-6 shadow-lg rounded-full bg-white">
              <i class="fas fa-sitemap text-xl"></i>
            </div>
            <h3 class="text-3xl mb-2 font-semibold leading-normal">Comprehensive HR Tools</h3>
            <p class="text-lg font-light leading-relaxed mt-4 mb-4 text-blueGray-600">
              Our HR management system offers a comprehensive suite of tools to simplify tasks like payroll, employee management, and more.
            </p>
            <div class="block pb-6">
              <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blueGray-500 bg-white uppercase last:mr-0 mr-2 mt-2">Employee Data</span>
              <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blueGray-500 bg-white uppercase last:mr-0 mr-2 mt-2">Performance Tracking</span>
              <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blueGray-500 bg-white uppercase last:mr-0 mr-2 mt-2">Reports</span>
              <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blueGray-500 bg-white uppercase last:mr-0 mr-2 mt-2">Automation</span>
            </div>
            <a
              href="https://www.creative-tim.com/learning-lab/tailwind/vue/alerts/notus?ref=vn-index"
              target="_blank"
              class="font-bold text-blueGray-700 hover:text-blueGray-500 ease-linear transition-all duration-150"
            >
              View All
              <i class="fa fa-angle-double-right ml-1 leading-relaxed"></i>
            </a>
          </div>

          <div class="w-full md:w-5/12 px-4 mr-auto ml-auto mt-32">
            <div class="relative flex flex-col min-w-0 w-full mb-6 mt-48 md:mt-0">
              <img
                alt="HR Dashboard"
                :src="componentBtn"
                class="w-full align-middle rounded absolute shadow-lg max-w-100-px left-145-px -top-29-px z-3"
              />
              <img
                alt="HR Dashboard"
                :src="componentProfileCard"
                class="w-full align-middle rounded-lg absolute shadow-lg max-w-210-px left-260-px -top-160-px"
              />
              <img
                alt="HR Dashboard"
                :src="componentInfoCard"
                class="w-full align-middle rounded-lg absolute shadow-lg max-w-180-px left-40-px -top-225-px z-2"
              />
              <img
                alt="HR Dashboard"
                :src="componentInfo2"
                class="w-full align-middle rounded-lg absolute shadow-2xl max-w-200-px -left-50-px top-25-px"
              />
              <img
                alt="HR Dashboard"
                :src="componentMenu"
                class="w-full align-middle rounded absolute shadow-lg max-w-580-px -left-20-px top-210-px"
              />
              <img
                alt="HR Dashboard"
                :src="componentBtnPink"
                class="w-full align-middle rounded absolute shadow-xl max-w-120-px left-195-px top-95-px"
              />
            </div>
          </div>
        </div>

        <div class="flex flex-wrap items-center pt-32">
          <div class="w-full md:w-6/12 px-4 mr-auto ml-auto mt-32">
            <div class="justify-center flex flex-wrap relative">
              <div class="my-4 w-full lg:w-6/12 px-4">
                <a
                  href="https://www.creativetim.com/learning-lab/tailwind/svelte/alerts/notus?ref=vn-index"
                  target="_blank"
                >
                  <div class="bg-red-600 shadow-lg rounded-lg text-center p-8">
                    <img
                      alt="HR Management"
                      class="shadow-md rounded-full max-w-full w-16 mx-auto p-2 bg-white"
                      src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/logos/svelte.jpg"
                    />
                    <p class="text-lg text-white mt-4 font-semibold">
                      Recruiters
                    </p>
                  </div>
                </a>
                <a
                  href="https://www.creativetim.com/learning-lab/tailwind/react/alerts/notus?ref=vn-index"
                  target="_blank"
                >
                  <div
                    class="bg-lightBlue-500 shadow-lg rounded-lg text-center p-8 mt-8"
                  >
                    <img
                      alt="HR Management"
                      class="shadow-md rounded-full max-w-full w-16 mx-auto p-2 bg-white"
                      src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/logos/react.jpg"
                    />
                    <p class="text-lg text-white mt-4 font-semibold">
                     Analytics
                    </p>
                  </div>
                </a>
                <a
                  href="https://www.creativetim.com/learning-lab/tailwind/nextjs/alerts/notus?ref=vn-index"
                  target="_blank"
                >
                  <div
                    class="bg-blueGray-700 shadow-lg rounded-lg text-center p-8 mt-8"
                  >
                    <img
                      alt="HR Management"
                      class="shadow-md rounded-full max-w-full w-16 mx-auto p-2 bg-white"
                      src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/logos/nextjs.jpg"
                    />
                    <p class="text-lg text-white mt-4 font-semibold">
                     Management
                    </p>
                  </div>
                </a>
              </div>
            </div>
          </div>

          <div class="w-full md:w-4/12 px-12 md:px-4 ml-auto mr-auto mt-48">
            <div class="text-blueGray-500 p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-6 shadow-lg rounded-full bg-white">
              <i class="fas fa-drafting-compass text-xl"></i>
            </div>
            <h3 class="text-3xl mb-2 font-semibold leading-normal">
              HR Components Overview
            </h3>
            <p class="text-lg font-light leading-relaxed mt-4 mb-4 text-blueGray-600">
              HR management components are designed to streamline operations and ensure efficient workforce management.
            </p>
            <p class="text-lg font-light leading-relaxed mt-4 mb-4 text-blueGray-600">
              The tools provide automation, reporting, and tracking functionalities that simplify HR processes.
            </p>
            <div class="block pb-6">
              <span
                class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blueGray-500 bg-white uppercase last:mr-0 mr-2 mt-2"
              >
                Alerts
              </span>
              <span
                class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blueGray-500 bg-white uppercase last:mr-0 mr-2 mt-2"
              >
                Onboarding
              </span>
              <span
                class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blueGray-500 bg-white uppercase last:mr-0 mr-2 mt-2"
              >
                Payroll
              </span>
              <span
                class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blueGray-500 bg-white uppercase last:mr-0 mr-2 mt-2"
              >
                Performance
              </span>
            </div>
            <a
              href="https://www.creative-tim.com/learning-lab/tailwind/vue/alerts/notus?ref=vn-index"
              target="_blank"
              class="font-bold text-blueGray-700 hover:text-blueGray-500 ease-linear transition-all duration-150"
            >
              View all
              <i class="fa fa-angle-double-right ml-1 leading-relaxed"></i>
            </a>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 pb-32 pt-48">
        <div class="items-center flex flex-wrap">
          <div class="w-full md:w-5/12 ml-auto px-12 md:px-4">
            <div class="md:pr-12">
              <div class="text-blueGray-500 p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-6 shadow-lg rounded-full bg-white">
                <i class="fas fa-file-alt text-xl"></i>
              </div>
              <h3 class="text-3xl font-semibold">Comprehensive HR Documentation</h3>
              <p class="mt-4 text-lg leading-relaxed text-blueGray-500">
                This tool offers a wide range of documentation features, including employee reports, contracts, and policy management.
              </p>
            </div>
          </div>

          <div class="w-full md:w-6/12 mr-auto px-4 pt-24 md:pt-0">
            <img
              alt="HR Documentation"
              class="max-w-full rounded-lg shadow-xl"
              style="transform: scale(1) perspective(1040px) rotateY(-11deg) rotateX(2deg) rotate(2deg);"
              src="../assets/demo2.png"
            />
          </div>
        </div>
      </div>
    </section>
    <footer-component />
  </div>
</template>
<style>
@keyframes fadeInUp {
  0% { opacity: 0; transform: translateY(20px); }
  100% { opacity: 1; transform: translateY(0); }
}

@keyframes slideInRight {
  0% { opacity: 0; transform: translateX(100px); }
  100% { opacity: 1; transform: translateX(0); }
}

.animate-fadeInUp {
  animation: fadeInUp 1s ease-out forwards;
}

.animate-slideInRight {
  animation: slideInRight 1.2s ease-out forwards;
}

.animate-fadeIn {
  animation: fadeInUp 2s ease-out forwards;
}

.delay-200 {
  animation-delay: 0.2s;
}

.delay-400 {
  animation-delay: 0.4s;
}</style>
<script>
import { loadStripe } from '@stripe/stripe-js';


import IndexNavbar from "@/components/Navbars/IndexNavbar.vue";
import FooterComponent from "@/components/Footers/Footer.vue";

import patternVue from "@/assets/img/pattern_vue.png";
import componentBtn from "@/assets/img/component-btn.png";
import componentProfileCard from "@/assets/img/component-profile-card.png";
import componentInfoCard from "@/assets/img/component-info-card.png";
import componentInfo2 from "@/assets/img/component-info-2.png";
import componentMenu from "@/assets/img/component-menu.png";
import componentBtnPink from "@/assets/img/component-btn-pink.png";
import documentation from "@/assets/img/documentation.png";
import login from "@/assets/img/login.jpg";
import profile from "@/assets/img/profile.jpg";
import landing from "@/assets/img/landing.jpg";
 

export default {
  async mounted() {
      this.stripe = await loadStripe(process.env.VUE_APP_PUBLISH_KEY);
  },

  methods: {
    async checkout() {
      this.loading = true;

      const response = await fetch('http://127.0.0.1:8000/api/create-checkout-session', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
      });

      const session = await response.json();

       const result = await this.stripe.redirectToCheckout({
        sessionId: session.id,
      });

      if (result.error) {
        console.error(result.error.message);
      }

      this.loading = false;
    },
  },
 
  data() {
    return {
      stripe: null,
      loading: false,
      patternVue,
      componentBtn,
      componentProfileCard,
      componentInfoCard,
      componentInfo2,
      componentMenu,
      componentBtnPink,
      documentation,
      login,
      profile,
      landing,
    };
  },
  components: {
    IndexNavbar,
    FooterComponent,
  },
};
</script>
