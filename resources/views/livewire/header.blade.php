  <div class="mb-6 relative">
      <div class="flex flex-col sm:flex-row items-center border-b border-gray-200 rounded-md">
          <div class="relative w-full sm:flex-grow">
              <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
              <input wire:model.live.debounce.100ms="searchTerm" type="text" class="p-2 pl-10 w-full focus:outline-none"
                  placeholder="Search...">
          </div>

          <div
              class="flex items-center gap-2 sm:gap-4 px-2 sm:px-4 py-2 sm:py-0 w-full sm:w-auto justify-between sm:justify-end border-gray-200">
              <button class="text-gray-400 hover:text-gray-600 flex items-center gap-1">
                  <i class="fas fa-bullhorn"></i>
                  <span class="text-xs sm:text-sm">Feedback?</span>
              </button>
              <button class="text-gray-400 hover:text-gray-600 relative">
                  <i class="fas fa-bell"></i>
                  <span
                      class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">
                      1
                  </span>
              </button>
              <button class="text-gray-400 hover:text-gray-600">
                  <i class="fas fa-question-circle"></i>
              </button>
              <button class="text-gray-400 hover:text-gray-600">
                  <i class="fas fa-user"></i>
              </button>
          </div>
      </div>
  </div>
