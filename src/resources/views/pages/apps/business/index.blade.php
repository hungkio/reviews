<x-default-layout>

    @section('title')
    Business
    @endsection
    <style>
        .container {
            width: 50%;
            margin: auto;
        }

        .form-group input[type="text"],
        .form-group input[type="url"],
        .form-group input[type="email"],
        .form-group input[type="color"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-top: 5px;
        }

        button[type="submit"] {
            background-color: #50cd89;
            color: white;
            padding: 14px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>

    <div class="container">
        <h2>Business</h2>
        <form method="POST" action="{{ route('business.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="business_name">Business Name:</label>
                <input type="text" id="business_name" name="business_name" required>
            </div>
            <div class="form-group">
                <label for="logo">Logo:</label>
                <input type="file" id="logo" name="logo" accept="image/*" multiple>
            </div>
            <div class="form-group">
                <label for="website_url">Website URL:</label>
                <input type="url" id="website_url" name="website_url" required>
            </div>
            <div class="form-group">
                <label for="color">Color:</label>
                <input type="color" id="color" name="color" required>
            </div>
            <div class="form-group">
                <label for="from_email">From Email Address:</label>
                <input type="email" id="from_email" name="from_email" required>
            </div>
            <div class="form-group">
                <label for="reply_to_email">Reply to Email Address:</label>
                <input type="email" id="reply_to_email" name="reply_to_email" required placeholder="">
            </div>
            
            <button type="submit" class="btn-success">Save</button>
        </form>
    </div>



</x-default-layout>