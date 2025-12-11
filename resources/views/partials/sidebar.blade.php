<aside
  :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
  class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
  <!-- SIDEBAR HEADER -->
  <div
    :class="sidebarToggle ? 'justify-center' : 'justify-between'"
    class="flex items-center gap-2 pt-8 sidebar-header pb-7"
  >
    <a href="index">
      <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
        <img class="dark:hidden" src="{{ SystemHelper::logoUrl() ?? './images/logo/logo.svg' }}" alt="Logo" />
        <img
          class="hidden dark:block"
          src="{{ SystemHelper::logoUrl(true) ?? './images/logo/logo-dark.svg' }}"
          alt="{{ SystemHelper::appName(); }} Logo"
        />
      </span>

      <img
        class="logo-icon"
        :class="sidebarToggle ? 'lg:block' : 'hidden'"
        src="{{ SystemHelper::logoUrl(true) ?? './images/logo/logo-icon.svg' }}"
        alt="{{ SystemHelper::appName(); }} Logo"
      />
    </a>
  </div>
  <!-- SIDEBAR HEADER -->

  <div
    class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar"
  >
    <!-- Sidebar Menu -->
    <nav x-data="{selected: $persist('Dashboard')}">
      <!-- Menu Group -->
      <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
          <span
            class="menu-group-title"
            :class="sidebarToggle ? 'lg:hidden' : ''"
          >
            MENU
          </span>

          <svg
            :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
            class="mx-auto fill-current menu-group-icon"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
              fill=""
            />
          </svg>
        </h3>

        <ul class="flex flex-col gap-4 mb-6">
          <!-- Menu Item Dashboard -->
          <li>
            <a
              href="{{ route('dashboard')}}"
              @click="selected = (selected === 'Dashboard' ? '':'Dashboard')"
              class="menu-item group"
              :class="(selected === 'Dashboard') && (page === 'dashboard') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'Dashboard') && (page === 'dashboard') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V8.99998C3.25 10.2426 4.25736 11.25 5.5 11.25H9C10.2426 11.25 11.25 10.2426 11.25 8.99998V5.5C11.25 4.25736 10.2426 3.25 9 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H9C9.41421 4.75 9.75 5.08579 9.75 5.5V8.99998C9.75 9.41419 9.41421 9.74998 9 9.74998H5.5C5.08579 9.74998 4.75 9.41419 4.75 8.99998V5.5ZM5.5 12.75C4.25736 12.75 3.25 13.7574 3.25 15V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H9C10.2426 20.75 11.25 19.7427 11.25 18.5V15C11.25 13.7574 10.2426 12.75 9 12.75H5.5ZM4.75 15C4.75 14.5858 5.08579 14.25 5.5 14.25H9C9.41421 14.25 9.75 14.5858 9.75 15V18.5C9.75 18.9142 9.41421 19.25 9 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V15ZM12.75 5.5C12.75 4.25736 13.7574 3.25 15 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V8.99998C20.75 10.2426 19.7426 11.25 18.5 11.25H15C13.7574 11.25 12.75 10.2426 12.75 8.99998V5.5ZM15 4.75C14.5858 4.75 14.25 5.08579 14.25 5.5V8.99998C14.25 9.41419 14.5858 9.74998 15 9.74998H18.5C18.9142 9.74998 19.25 9.41419 19.25 8.99998V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H15ZM15 12.75C13.7574 12.75 12.75 13.7574 12.75 15V18.5C12.75 19.7426 13.7574 20.75 15 20.75H18.5C19.7426 20.75 20.75 19.7427 20.75 18.5V15C20.75 13.7574 19.7426 12.75 18.5 12.75H15ZM14.25 15C14.25 14.5858 14.5858 14.25 15 14.25H18.5C18.9142 14.25 19.25 14.5858 19.25 15V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15C14.5858 19.25 14.25 18.9142 14.25 18.5V15Z"
                  fill=""
                />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Dashboard
              </span>
            </a>
          </li>
          <!-- Menu Item Dashboard -->

          <!-- Menu Item Reports -->
          <li>
            <a
              href="{{ route('reports.index') }}"
              @click="selected = (selected === 'Reports' ? '' : 'Reports')"
              class="menu-item group"
              :class="(selected === 'Reports') && (page === 'reports') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'Reports') && (page === 'reports') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path 
                  d="M4 4H20V6H4V4ZM4 8H14V10H4V8ZM4 12H20V14H4V12ZM4 16H14V18H4V16Z"
                  fill=""
                />
              </svg>

              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                Reports
              </span>
            </a>
          </li>
          <!-- End Menu Item Reports -->


          <!-- Menu Item Calendar -->
          {{-- <li>
            <a
              href="calendar"
              @click="selected = (selected === 'Calendar' ? '':'Calendar')"
              class="menu-item group"
              :class=" (selected === 'Calendar') && (page === 'calendar') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'Calendar') && (page === 'calendar') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M8 2C8.41421 2 8.75 2.33579 8.75 2.75V3.75H15.25V2.75C15.25 2.33579 15.5858 2 16 2C16.4142 2 16.75 2.33579 16.75 2.75V3.75H18.5C19.7426 3.75 20.75 4.75736 20.75 6V9V19C20.75 20.2426 19.7426 21.25 18.5 21.25H5.5C4.25736 21.25 3.25 20.2426 3.25 19V9V6C3.25 4.75736 4.25736 3.75 5.5 3.75H7.25V2.75C7.25 2.33579 7.58579 2 8 2ZM8 5.25H5.5C5.08579 5.25 4.75 5.58579 4.75 6V8.25H19.25V6C19.25 5.58579 18.9142 5.25 18.5 5.25H16H8ZM19.25 9.75H4.75V19C4.75 19.4142 5.08579 19.75 5.5 19.75H18.5C18.9142 19.75 19.25 19.4142 19.25 19V9.75Z"
                  fill=""
                />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Calendar
              </span>
            </a>
          </li> --}}
          <!-- Menu Item Calendar -->

    
          <!-- Menu Item Forms -->
          {{-- <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'Forms' ? '':'Forms')"
              class="menu-item group"
              :class=" (selected === 'Forms') || (page === 'formElements' || page === 'formLayout' || page === 'proFormElements' || page === 'proFormLayout') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'Forms') || (page === 'formElements' || page === 'formLayout' || page === 'proFormElements' || page === 'proFormLayout') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H18.5001C19.7427 20.75 20.7501 19.7426 20.7501 18.5V5.5C20.7501 4.25736 19.7427 3.25 18.5001 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H18.5001C18.9143 4.75 19.2501 5.08579 19.2501 5.5V18.5C19.2501 18.9142 18.9143 19.25 18.5001 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V5.5ZM6.25005 9.7143C6.25005 9.30008 6.58583 8.9643 7.00005 8.9643L17 8.96429C17.4143 8.96429 17.75 9.30008 17.75 9.71429C17.75 10.1285 17.4143 10.4643 17 10.4643L7.00005 10.4643C6.58583 10.4643 6.25005 10.1285 6.25005 9.7143ZM6.25005 14.2857C6.25005 13.8715 6.58583 13.5357 7.00005 13.5357H17C17.4143 13.5357 17.75 13.8715 17.75 14.2857C17.75 14.6999 17.4143 15.0357 17 15.0357H7.00005C6.58583 15.0357 6.25005 14.6999 6.25005 14.2857Z"
                  fill=""
                />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Forms
              </span>

              <svg
                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                :class="[(selected === 'Forms') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
                  stroke=""
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </a>

            <!-- Dropdown Menu Start -->
            <div
              class="overflow-hidden transform translate"
              :class="(selected === 'Forms') ? 'block' :'hidden'"
            >
              <ul
                :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9"
              >
                <li>
                  <a
                    href="form-elements"
                    class="menu-dropdown-item group"
                    :class="page === 'formElements' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    Form Elements
                  </a>
                </li>
              </ul>
            </div>
            <!-- Dropdown Menu End -->
          </li> --}}
          <!-- Menu Item Forms -->

          <!-- Menu Item Tables -->
          {{-- <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'Tables' ? '':'Tables')"
              class="menu-item group"
              :class="(selected === 'Tables') || (page === 'basicTables' || page === 'dataTables') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'Tables') || (page === 'basicTables' || page === 'dataTables') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M3.25 5.5C3.25 4.25736 4.25736 3.25 5.5 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V18.5C20.75 19.7426 19.7426 20.75 18.5 20.75H5.5C4.25736 20.75 3.25 19.7426 3.25 18.5V5.5ZM5.5 4.75C5.08579 4.75 4.75 5.08579 4.75 5.5V8.58325L19.25 8.58325V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H5.5ZM19.25 10.0833H15.416V13.9165H19.25V10.0833ZM13.916 10.0833L10.083 10.0833V13.9165L13.916 13.9165V10.0833ZM8.58301 10.0833H4.75V13.9165H8.58301V10.0833ZM4.75 18.5V15.4165H8.58301V19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5ZM10.083 19.25V15.4165L13.916 15.4165V19.25H10.083ZM15.416 19.25V15.4165H19.25V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15.416Z"
                  fill=""
                />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Tables
              </span>

              <svg
                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                :class="[(selected === 'Tables') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
                  stroke=""
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </a>

            <!-- Dropdown Menu Start -->
            <div
              class="overflow-hidden transform translate"
              :class="(selected === 'Tables') ? 'block' :'hidden'"
            >
              <ul
                :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9"
              >
                <li>
                  <a
                    href="basic-tables"
                    class="menu-dropdown-item group"
                    :class="page === 'basicTables' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    Basic Tables
                  </a>
                </li>
              </ul>
            </div>
            <!-- Dropdown Menu End -->
          </li> --}}
          <!-- Menu Item Tables -->

          <!-- Menu Item Pages -->
          {{-- <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'Pages' ? '':'Pages')"
              class="menu-item group"
              :class="(selected === 'Pages') || (page === 'fileManager' || page === 'pricingTables' || page === 'blank' || page === 'page404' || page === 'page500' || page === 'page503' || page === 'success' || page === 'faq' || page === 'comingSoon' || page === 'maintenance') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'Pages') || (page === 'fileManager' || page === 'pricingTables' || page === 'blank' || page === 'page404' || page === 'page500' || page === 'page503' || page === 'success' || page === 'faq' || page === 'comingSoon' || page === 'maintenance') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M8.50391 4.25C8.50391 3.83579 8.83969 3.5 9.25391 3.5H15.2777C15.4766 3.5 15.6674 3.57902 15.8081 3.71967L18.2807 6.19234C18.4214 6.333 18.5004 6.52376 18.5004 6.72268V16.75C18.5004 17.1642 18.1646 17.5 17.7504 17.5H16.248V17.4993H14.748V17.5H9.25391C8.83969 17.5 8.50391 17.1642 8.50391 16.75V4.25ZM14.748 19H9.25391C8.01126 19 7.00391 17.9926 7.00391 16.75V6.49854H6.24805C5.83383 6.49854 5.49805 6.83432 5.49805 7.24854V19.75C5.49805 20.1642 5.83383 20.5 6.24805 20.5H13.998C14.4123 20.5 14.748 20.1642 14.748 19.75L14.748 19ZM7.00391 4.99854V4.25C7.00391 3.00736 8.01127 2 9.25391 2H15.2777C15.8745 2 16.4468 2.23705 16.8687 2.659L19.3414 5.13168C19.7634 5.55364 20.0004 6.12594 20.0004 6.72268V16.75C20.0004 17.9926 18.9931 19 17.7504 19H16.248L16.248 19.75C16.248 20.9926 15.2407 22 13.998 22H6.24805C5.00541 22 3.99805 20.9926 3.99805 19.75V7.24854C3.99805 6.00589 5.00541 4.99854 6.24805 4.99854H7.00391Z"
                  fill=""
                />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Pages
              </span>

              <svg
                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                :class="[(selected === 'Pages') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
                  stroke=""
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </a>

            <!-- Dropdown Menu Start -->
            <div
              class="overflow-hidden transform translate"
              :class="(selected === 'Pages') ? 'block' :'hidden'"
            >
              <ul
                :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9"
              >
                <li>
                  <a
                    href="blank"
                    class="menu-dropdown-item group"
                    :class="page === 'blank' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    Blank Page
                  </a>
                </li>
                <li>
                  <a
                    href="404"
                    class="menu-dropdown-item group"
                    :class="page === 'page404' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    404 Error
                  </a>
                </li>
              </ul>
            </div>
            <!-- Dropdown Menu End -->
          </li> --}}
          <!-- Menu Item Pages -->
        </ul>
      </div>

      <!-- Others Group -->
      <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
          <span
            class="menu-group-title"
            :class="sidebarToggle ? 'lg:hidden' : ''"
          >
            others
          </span>

          <svg
            :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
            class="mx-auto fill-current menu-group-icon"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
              fill=""
            />
          </svg>
        </h3>

        <ul class="flex flex-col gap-4 mb-6">
          <!-- Menu Item System -->
          @if(auth()->user() && auth()->user()->isAdmin())
          <li>
              <a
                href="{{ route('system.index') }}"
                @click="selected = (selected === 'System' ? '' : 'System')"
                class="menu-item group"
                :class="(selected === 'System') && (page === 'system') ? 'menu-item-active' : 'menu-item-inactive'"
              >
                <svg
                  :class="(selected === 'System') && (page === 'system') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path 
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M12 2C12.4142 2 12.75 2.33579 12.75 2.75V4.143C13.7104 4.32977 14.6141 4.74403 15.385 5.353L16.348 4.39C16.6405 4.09746 17.1174 4.09746 17.41 4.39L19.61 6.59C19.9025 6.88254 19.9025 7.35946 19.61 7.652L18.647 8.615C19.256 9.38591 19.6703 10.2896 19.857 11.25H21.25C21.6642 11.25 22 11.5858 22 12C22 12.4142 21.6642 12.75 21.25 12.75H19.857C19.6703 13.7104 19.256 14.6141 18.647 15.385L19.61 16.348C19.9025 16.6405 19.9025 17.1174 19.61 17.41L17.41 19.61C17.1174 19.9025 16.6405 19.9025 16.348 19.61L15.385 18.647C14.6141 19.256 13.7104 19.6703 12.75 19.857V21.25C12.75 21.6642 12.4142 22 12 22C11.5858 22 11.25 21.6642 11.25 21.25V19.857C10.2896 19.6703 9.38591 19.256 8.615 18.647L7.652 19.61C7.35946 19.9025 6.88254 19.9025 6.59 19.61L4.39 17.41C4.09746 17.1174 4.09746 16.6405 4.39 16.348L5.353 15.385C4.74403 14.6141 4.32977 13.7104 4.143 12.75H2.75C2.33579 12.75 2 12.4142 2 12C2 11.5858 2.33579 11.25 2.75 11.25H4.143C4.32977 10.2896 4.74403 9.38591 5.353 8.615L4.39 7.652C4.09746 7.35946 4.09746 6.88254 4.39 6.59L6.59 4.39C6.88254 4.09746 7.35946 4.09746 7.652 4.39L8.615 5.353C9.38591 4.74403 10.2896 4.32977 11.25 4.143V2.75C11.25 2.33579 11.5858 2 12 2ZM12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9Z"
                    fill=""
                  />
                </svg>

                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                  System
                </span>
              </a>
          </li>
          @endif

          {{-- In your sidebar.blade.php --}}
          @if(auth()->user()->isAdmin())
          <li class="menu-item">
              <a href="{{ route('admin.users.index') }}" class="menu-link">
                  <div class="menu-icon">
                      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.281.053-.562.106-.844.155m-12.656 0c.281-.053.562-.106.844-.155m12.656 0a9 9 0 01-12.656 0"/>
                      </svg>
                  </div>
                  <div class="menu-text">User Management</div>
              </a>
          </li>
          @endif

          <!-- End Menu Item System -->

          <!-- End Menu Item System -->

          <!-- Menu Item Charts -->
          {{-- <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'Charts' ? '':'Charts')"
              class="menu-item group"
              :class="(selected === 'Charts') || (page === 'lineChart' || page === 'barChart' || page === 'pieChart') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'Charts') || (page === 'lineChart' || page === 'barChart' || page === 'pieChart') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M12 2C11.5858 2 11.25 2.33579 11.25 2.75V12C11.25 12.4142 11.5858 12.75 12 12.75H21.25C21.6642 12.75 22 12.4142 22 12C22 6.47715 17.5228 2 12 2ZM12.75 11.25V3.53263C13.2645 3.57761 13.7659 3.66843 14.25 3.80098V3.80099C15.6929 4.19606 16.9827 4.96184 18.0104 5.98959C19.0382 7.01734 19.8039 8.30707 20.199 9.75C20.3316 10.2341 20.4224 10.7355 20.4674 11.25H12.75ZM2 12C2 7.25083 5.31065 3.27489 9.75 2.25415V3.80099C6.14748 4.78734 3.5 8.0845 3.5 12C3.5 16.6944 7.30558 20.5 12 20.5C15.9155 20.5 19.2127 17.8525 20.199 14.25H21.7459C20.7251 18.6894 16.7492 22 12 22C6.47715 22 2 17.5229 2 12Z"
                  fill=""
                />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Charts
              </span>

              <svg
                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                :class="[(selected === 'Charts') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
                  stroke=""
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </a>

            <!-- Dropdown Menu Start -->
            <div
              class="overflow-hidden transform translate"
              :class="(selected === 'Charts') ? 'block' :'hidden'"
            >
              <ul
                :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9"
              >
                <li>
                  <a
                    href="line-chart"
                    class="menu-dropdown-item group"
                    :class="page === 'lineChart' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    Line Chart
                  </a>
                </li>
                <li>
                  <a
                    href="bar-chart"
                    class="menu-dropdown-item group"
                    :class="page === 'barChart' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    Bar Chart
                  </a>
                </li>
              </ul>
            </div>
            <!-- Dropdown Menu End -->
          </li> --}}
          <!-- Menu Item Charts -->

          <!-- Menu Item Ui Elements -->
          {{-- <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'UIElements' ? '':'UIElements')"
              class="menu-item group"
              :class="(selected === 'UIElements') || (page === 'alerts' || page === 'avatars' || page === 'badge' || page === 'buttons' || page === 'buttonsGroup' || page === 'cards'|| page === 'carousel' || page === 'dropdowns' || page === 'images' || page === 'list' || page === 'modals' || page === 'videos') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'UIElements') || (page === 'alerts' || page === 'avatars' || page === 'badge' || page === 'breadcrumb' || page === 'buttons' || page === 'buttonsGroup' || page === 'cards'|| page === 'carousel' || page === 'dropdowns' || page === 'images' || page === 'list' || page === 'modals' || page === 'notifications' || page === 'popovers' || page === 'progress' || page === 'spinners' || page === 'tooltips' || page === 'videos') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M11.665 3.75618C11.8762 3.65061 12.1247 3.65061 12.3358 3.75618L18.7807 6.97853L12.3358 10.2009C12.1247 10.3064 11.8762 10.3064 11.665 10.2009L5.22014 6.97853L11.665 3.75618ZM4.29297 8.19199V16.0946C4.29297 16.3787 4.45347 16.6384 4.70757 16.7654L11.25 20.0365V11.6512C11.1631 11.6205 11.0777 11.5843 10.9942 11.5425L4.29297 8.19199ZM12.75 20.037L19.2933 16.7654C19.5474 16.6384 19.7079 16.3787 19.7079 16.0946V8.19199L13.0066 11.5425C12.9229 11.5844 12.8372 11.6207 12.75 11.6515V20.037ZM13.0066 2.41453C12.3732 2.09783 11.6277 2.09783 10.9942 2.41453L4.03676 5.89316C3.27449 6.27429 2.79297 7.05339 2.79297 7.90563V16.0946C2.79297 16.9468 3.27448 17.7259 4.03676 18.1071L10.9942 21.5857L11.3296 20.9149L10.9942 21.5857C11.6277 21.9024 12.3732 21.9024 13.0066 21.5857L19.9641 18.1071C20.7264 17.7259 21.2079 16.9468 21.2079 16.0946V7.90563C21.2079 7.05339 20.7264 6.27429 19.9641 5.89316L13.0066 2.41453Z"
                  fill=""
                />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                UI Elements
              </span>

              <svg
                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                :class="[(selected === 'UIElements') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
                  stroke=""
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </a>

            <!-- Dropdown Menu Start -->
            <div
              class="overflow-hidden transform translate"
              :class="(selected === 'UIElements') ? 'block' :'hidden'"
            >
              <ul
                :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9"
              >
                <li>
                  <a
                    href="alerts"
                    class="menu-dropdown-item group"
                    :class="page === 'alerts' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    Alerts
                  </a>
                </li>
                <li>
                  <a
                    href="avatars"
                    class="menu-dropdown-item group"
                    :class="page === 'avatars' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    Avatars
                  </a>
                </li>
                <li>
                  <a
                    href="badge"
                    class="menu-dropdown-item group"
                    :class="page === 'badge' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    Badges
                  </a>
                </li>
                <li>
                  <a
                    href="buttons"
                    class="menu-dropdown-item group"
                    :class="page === 'buttons' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    Buttons
                  </a>
                </li>
                <li>
                  <a
                    href="images"
                    class="menu-dropdown-item group"
                    :class="page === 'images' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    Images
                  </a>
                </li>
                <li>
                  <a
                    href="videos"
                    class="menu-dropdown-item group"
                    :class="page === 'videos' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    Videos
                  </a>
                </li>
              </ul>
            </div>
            <!-- Dropdown Menu End -->
          </li> --}}
          <!-- Menu Item Ui Elements -->

        </ul>
      </div>
    </nav>
    <!-- Sidebar Menu -->

  </div>
</aside>
