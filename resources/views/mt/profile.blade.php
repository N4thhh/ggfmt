<div class="grid grid-cols-4 md:grid-cols-6 grid-rows-10 md:grid-rows-6 gap-2 md:gap-4 m-4">
    <div class="col-start-1 row-start-1 col-span-2 row-span-2 md:col-start-1 md:row-start-1 md:col-span-1 md:row-span-2 bg-gray-300 rounded-md p-10">
        <img src="{{ asset('images/mt-profile.jpg') }}" alt="Profile Image" class="profile-image">
    </div>
    <div class="col-start-3 row-start-1 col-span-2 md:col-start-1 md:row-start-3 md:col-span-1 md:row-span-1 bg-gray-300 rounded-md p-10">
        <p><strong>{{$managementTrainee->status}}</strong></p>
    </div>
    <div class="col-start-3 row-start-2 col-span-2 md:col-start-1 md:row-start-4 md:col-span-1 md:row-span-3 bg-gray-300 rounded-md p-10">
        <p><strong>Index Number:</strong> {{ $managementTrainee->index_number }}</p>
        <p><strong>Batch:</strong> {{ $managementTrainee->batch }}</p>
        <p><strong>MBTI:</strong> {{ $managementTrainee->mbti }}</p>
        <p><strong>Major:</strong> {{ $managementTrainee->major }}</p>
        <p><strong>University:</strong> {{ $managementTrainee->university }}</p>
        <p><strong>Education Degree:</strong> {{ $managementTrainee-> education_degree }}</p>
        <p><strong>Placement:</strong> {{ $managementTrainee->placement }}</p>
        <p><strong>Program Leader:</strong> {{ $managementTrainee->program_leader }}</p>
        <p><strong>Assignment Leader:</strong> {{ $managementTrainee->assignment_leader }}</p>
        <p><strong>Coach:</strong> {{ $managementTrainee->coachHistory()->where('ended_at', null)->first()?->coach?->user?->name ?? 'N/A' }}</p>
        <p><strong>Program:</strong> {{ $managementTrainee->mtProgram->name }}</p>
    </div>
    <div class="col-start-1 row-start-3 col-span-4 row-span-2 md:col-start-2 md:row-start-1 md:col-span-3 md:row-span-3 bg-gray-300 rounded-md p-10">
        <div class="tab-buttons">
        @foreach ($managementTrainee->assignment as $assignment)
            <button onclick="showAssignment('{{ $assignment->phase }}')">
                {{ $assignment->phase }}
            </button>
        @endforeach
        </div>

        @foreach ($managementTrainee->assignment as $index => $assignment)
        <div id="assignment-{{ $assignment->phase }}"
             class="tab-content"
             style="display: {{ $index === 0 ? 'block' : 'none' }};">
            <p><strong>Title:</strong> {{ $assignment->title }}</p>
            @if($assignment->file_path)
                <iframe src="{{ asset('storage/' . $assignment->file_path) }}" width="100%" height="500px"></iframe>            <p><strong>Uploaded At:</strong> {{ $assignment->uploaded_at ?? 'N/A' }}</p>
            @else
                <p>No file uploaded.</p>
            @endif
        </div>
        @endforeach
    </div>
    <div class="col-start-1 row-start-5 col-span-4 md:col-start-5 md:row-start-1 md:col-span-2 md:row-span-1 bg-gray-300 rounded-md p-10">
        @foreach ($managementTrainee->assignment as $index => $assignment)    
        <div id="score-{{ $assignment->phase }}" class="tab-content" style="display: {{ $index === 0 ? 'block' : 'none' }};">
            @foreach ($assignment->score as $score)
                <p><strong>Score for {{ $assignment->phase }}:</strong> {{ $score->score ?? 'N/A' }} </p>
            @endforeach    
        </div>
        @endforeach
    </div>
    <div class="col-start-1 row-start-6 col-span-4 row-span-2 md:col-start-5 md:row-start-2 md:col-span-2 md:row-span-2 bg-gray-300 rounded-md p-10">
        @foreach ($managementTrainee->assignment as $index => $assignment)
        <div id="comment-{{ $assignment->phase }}" class="tab-content" style="display: {{ $index === 0 ? 'block' : 'none' }};">
            @foreach ($assignment->score as $score)
            <p><strong>Comment for {{ $assignment->phase }}:</strong> {{ $score->comments ?? 'N/A' }}</p>
            @endforeach
        </div>
        @endforeach
    </div>

    <div class="col-start-1 row-start-8 col-span-4 row-span-3 md:col-start-2 md:row-start-4 md:col-span-5 md:row-span-3 bg-gray-300 rounded-md p-10">
        <div class="date-dropdown">
            <label for="coach-date-select">Coaching Date:</label>
            <select id="coach-date-select" onchange="showCoachNote(this.value)">
                @foreach ($managementTrainee->coachNote as $coachNote)
                    <option value="{{ $coachNote->created_at }}">{{ $coachNote->created_at }}</option>
                @endforeach
            </select>
        </div>
        
        @foreach ($managementTrainee->coachNote as $coachNote)
        <div id="date-{{ $coachNote->created_at }}" class="tab-content" style="display: none;">
            <p><strong>Comments:</strong> {{ $coachNote->comments }} </p> 
        </div>
        @endforeach
    </div>
      
    </div>

    <script>

        function showAssignment(phase) {
            document.querySelectorAll('.tab-content').forEach(el => {
                el.style.display = 'none';
            });
        document.getElementById('assignment-' + phase).style.display = 'block';
        document.getElementById('score-' + phase).style.display = 'block';
        document.getElementById('comment-' + phase).style.display = 'block';
        }
        
        function showCoachNote(created_at) {
            document.querySelectorAll('.tab-content').forEach(el => {
                el.style.display = 'none';
            });
            document.getElementById('date-' + created_at).style.display = 'block';
        }
    </script>