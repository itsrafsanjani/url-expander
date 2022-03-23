<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta charset="UTF-8">
    <link rel="icon" href="./favicon.ico">
    <link rel="manifest" href="./webmanifest.json">
    <title>URL Expander</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="flex flex-col justify-center items-center min-h-screen bg-gray-900">
<h1 class="text-center text-4xl text-gray-100 py-3">URL Expander</h1>
<form x-data="getExpandedUrlForm" @submit.prevent="submitData" class="p-3 md:w-2/6">
    <div class="flex justify-center">
        <input type="text" name="url" class="flex-1 p-3 focus:outline-none"
               placeholder="Paste any short URL (https://bit.ly/3qb40Bs)"
               x-model="formData.url">
        <button class="ml-2 p-3 bg-gray-600 disabled:opacity-50 text-gray-100" x-text="buttonLabel" :disabled="loading">
            Submit
        </button>
    </div>
    <p x-text="message" :class="{ 'hidden': ! error }" class="hidden mt-4 text-center text-red-600"></p>
    <div :class="{ 'hidden': ! display }" class="hidden mt-2"><p class="text-center text-gray-100">Expanded URL</p>
        <a :href="expandedUrl" target="_blank">
            <p class="break-all mt-2 p-3 bg-gray-600 rounded text-white" x-text="expandedUrl"></p>
        </a>
    </div>
</form>
</body>

<script>
    function getExpandedUrlForm() {
        return {
            formData: {
                url: '',
            },
            loading: false,
            error: false,
            display: false,
            buttonLabel: 'Submit',
            message: '',
            expandedUrl: '',
            submitData() {
                if (this.formData.url.trim().length > 0) {
                    this.error = false
                    this.buttonLabel = 'Submitting...'
                    this.loading = true;
                    this.message = ''

                    fetch('/ajax.php', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(this.formData)
                    })
                        .then(response => response.json())
                        .then((data) => {
                            this.message = data.message
                            data.success === false ? this.error = true : this.error = false
                            this.display = true
                            this.expandedUrl = data.url
                        })
                        .catch(() => {
                            this.message = 'Oops! Something went wrong!'
                        })
                        .finally(() => {
                            this.loading = false;
                            this.buttonLabel = 'Submit'
                        })
                } else {
                    this.error = true
                    this.display = false
                    this.message = 'Please enter a url!'
                }
            }
        }
    }
</script>
</html>