<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .form {
            margin: 20px;

        }

        .form form {
            display: flex;
            flex-direction: column;
            width: 50%;
        }

        .form form textarea {
            margin-bottom: 10px;
        }

        .form form label {
            margin-bottom: 10px;
        }

        .form form input {
            margin-bottom: 10px;
        }

        .badge {
            background-color: #f2f2f2;
            padding: 5px;
            margin-right: 5px;
            margin-bottom: 5px;
            display: inline-block;
            background-color: chartreuse;
            color: blue;
        }
        

    </style>
</head>
<body>
    <div class="form">
        <form action="{{ route('resume.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="job_description">Enter Job description and sort resume</label>
            <textarea name="job_description" id="" cols="30" rows="10"></textarea>
            <label for="file">Upload Resumes</label>
            <input type="file" name="resume[]" id="file" accept=".pdf" multiple>
            <button type="submit">Upload</button>
        </form>
    </div>

    @isset($data)


    <table>
        <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Location</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Highest Degree</th>
            <th>Total Work Experience</th>
            <th>Skill Set</th>
            <th>Key Achievements</th>
            <th>Current/Previous Role</th>
            <th>Years of Experience</th>
            <th>Expected Salary</th>
            <th>Availability</th>
            <th>Languages Known</th>
            <th>LinkedIn Profile</th>
            <th>Portfolio/Website</th>
            <th>References/Referrals</th>
        </tr>
        @php
            function checkNull($value) {
                return $value ? $value : 'Not Mentioned';
            }
        @endphp

        @foreach ($data as $resume)
            @php
                $resume = json_decode($resume, true);
            @endphp
            <tr>
                <td>{{ checkNull($resume['name']) }}</td>
                <td>{{ checkNull($resume['age']) }}</td>
                <td>{{ checkNull($resume['location']) }}</td>
                <td>{{ checkNull($resume['email']) }}</td>
                <td>{{ checkNull($resume['phone_number']) }}</td> 
                <td>{{ checkNull($resume['highest_degree']) }}</td>
                <td>{{ checkNull($resume['total_work_experience']) }}</td> 
                <td>
                    @if($resume['skill_set'])
                        @if(is_array($resume['skill_set']))
                            @foreach($resume['skill_set'] as $skill)
                            <span class="badge">{{ $skill }}</span>
                            @endforeach
                        @else
                            {{ checkNull($resume['skill_set']) }}
                        @endif
                    @endif
                </td>
                <td>
                    {{-- {{ $resume['key_achievements'] }} --}}
                    @if($resume['key_achievements'])
                        @if(is_array($resume['key_achievements']))
                            @foreach($resume['key_achievements'] as $achievement)
                                <span class="badge">{{ $achievement }}</span>
                            @endforeach
                        @else
                            {{ checkNull($resume['key_achievements']) }}
                        @endif
                    @endif
                </td>
                <td>
                    {{-- {{ $resume['current_previous_role'] }} --}}
                    @if($resume['current_previous_role'])
                        @if(is_array($resume['current_previous_role']))
                            @foreach($resume['current_previous_role'] as $role)
                            <span class="badge">{{ $role }}</span>
                            @endforeach
                        @else
                            {{ checkNull($resume['current_previous_role']) }}
                        @endif
                    @endif
                </td>
                <td>{{ checkNull($resume['years_of_experience']) }}</td>
                <td>{{ checkNull($resume['expected_salary']) }}</td>
                <td>{{ checkNull($resume['availability']) }}</td>
                <td>
                    @if($resume['languages_known'])
                        @if(is_array($resume['languages_known']))
                            @foreach($resume['languages_known'] as $language)
                            <span class="badge">{{ $language }}</span>
                            @endforeach
                        @else
                            {{ checkNull($resume['languages_known']) }}
                        @endif
                    @endif
                </td>
                <td>{{ checkNull($resume['linkedin_profile']) }}</td>
                <td>{{ checkNull($resume['portfolio_website']) }}</td>
                <td>
                    @if($resume['references_referrals'])
                        @if(is_array($resume['references_referrals']))
                            @foreach($resume['references_referrals'] as $referral)
                            <span class="badge">{{ $referral }}</span>
                            @endforeach
                        @else
                            {{ checkNull($resume['references_referrals']) }}
                        @endif
                    @endif
                </td>
            </tr>
            
        @endforeach
    </table>

    @endisset
</body>
</html>