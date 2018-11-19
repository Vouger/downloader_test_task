<table class="table">
    <thead>
        <tr>
            <th>
                Source Url 
            </th>
            <th>
                Filename
            </th>
            <th>
                Status
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($downloader_data as $downloader_object)
        <tr>
            <td>
                {{$downloader_object->source_url}}
            </td>
            <td>
                <a href="{{route('download_url', ['id' => $downloader_object->id])}}">
                    {{$downloader_object->filename}}
                </a>
            </td>
            <td>
                {{$downloader_object->status_name}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>