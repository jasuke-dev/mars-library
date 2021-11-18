<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Windmill Dashboard</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href= {{ asset("css/tailwind.output.css") }} />
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>
    <script src={{ asset("js/template/init-alpine.js") }}></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css"
    />
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
      defer
    ></script>
    <script src={{ asset("js/template/charts-lines.js") }} defer></script>
    <script src={{ asset("js/template/charts-pie.js") }} defer></script>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script nomodule src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine-ie11.min.js" defer></script>
    {{-- multiple select --}}
  </head>
  <body>
    <div
    class="flex h-screen bg-gray-50 dark:bg-gray-900"
    :class="{ 'overflow-hidden': isSideMenuOpen }"
    >

    @include('dashboard.partials.sidebar')

    <div class="flex flex-col flex-1 w-full">
        @include('dashboard.partials.header')
        @yield('container')
    </div>

    <script>
      function showImage() {
          return {
              showPreview(event) {
                  if (event.target.files.length > 0) {
                      var src = URL.createObjectURL(event.target.files[0]);
                      var preview = document.getElementById("preview");
                      preview.src = src;
                      preview.style.display = "block";
                  }
              }
          }
      }

      function dropdown() {
        return {
            options: [],
            selected: [],
            show: false,
            open() { this.show = true },
            close() { this.show = false },
            isOpen() { return this.show === true },
            select(index, event) {

                if (!this.options[index].selected) {

                    this.options[index].selected = true;
                    this.options[index].element = event.target;
                    this.selected.push(index);

                } else {
                    this.selected.splice(this.selected.lastIndexOf(index), 1);
                    this.options[index].selected = false
                }
            },
            remove(index, option) {
                this.options[option].selected = false;
                this.selected.splice(index, 1);


            },
            loadOptions() {
                const options = document.getElementById('select').options;
                for (let i = 0; i < options.length; i++) {
                    this.options.push({
                        value: options[i].value,
                        text: options[i].innerText,
                        selected: options[i].getAttribute('selected') != null ? options[i].getAttribute('selected') : false
                    });
                }


            },
            selectedValues(){
                return this.selected.map((option)=>{
                    return this.options[option].value;
                })
            }
        }
    }
  </script>
</body>
</html>