@props(['course', 'currentContent'])

<aside class="w-80 bg-white border-r border-gray-200 flex-col overflow-y-auto z-10 hidden md:flex">
    <div class="p-4 border-b border-gray-100 bg-gray-50">
        <h3 class="font-bold text-gray-700 text-sm uppercase tracking-wider">Kurikulum</h3>
    </div>
    <div class="flex-1 py-2 space-y-1">
        @foreach($course->materials as $material)
            <div class="px-5 py-2 mt-2"><h4 class="font-bold text-gray-800 text-sm">{{ $material->title }}</h4></div>

            {{-- Sub Materials (Video/PDF) --}}
            @foreach($material->subMaterials as $sub)
                @php $isActive = $currentContent && $currentContent->id == $sub->id && $currentContent->content_type == 'material'; @endphp
                <a href="{{ route('courses.show', ['course' => $course->id, 'type' => 'material', 'id' => $sub->id]) }}"
                   class="flex items-center gap-3 px-5 py-3 border-l-4 transition hover:bg-gray-50 {{ $isActive ? 'bg-indigo-50 border-indigo-600' : 'border-transparent' }}">
                    <svg class="w-4 h-4 {{ $isActive ? 'text-indigo-600' : 'text-gray-400' }}" fill="{{ $sub->type == 'video' ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sub->type == 'video' ? 'M8 5v14l11-7z' : 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z' }}"></path></svg>
                    <span class="text-sm {{ $isActive ? 'font-medium text-indigo-700' : 'text-gray-600' }}">{{ $sub->title }}</span>
                </a>
            @endforeach

            {{-- Assignments --}}
            @foreach($material->assignments as $assign)
                @php $isActive = $currentContent && $currentContent->id == $assign->id && $currentContent->content_type == 'assignment'; @endphp
                <a href="{{ route('courses.show', ['course' => $course->id, 'type' => 'assignment', 'id' => $assign->id]) }}"
                   class="flex items-center gap-3 px-5 py-3 border-l-4 transition hover:bg-gray-50 {{ $isActive ? 'bg-orange-50 border-orange-500' : 'border-transparent' }}">
                    <svg class="w-4 h-4 {{ $isActive ? 'text-orange-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span class="text-sm {{ $isActive ? 'font-medium text-orange-700' : 'text-gray-600' }}">{{ $assign->title }}</span>
                </a>
            @endforeach

            {{-- Quizzes --}}
            @foreach($material->quizzes as $quizItem)
                @php $isActive = $currentContent && $currentContent->id == $quizItem->id && $currentContent->content_type == 'quiz'; @endphp
                <a href="{{ route('courses.show', ['course' => $course->id, 'type' => 'quiz', 'id' => $quizItem->id]) }}"
                   class="flex items-center gap-3 px-5 py-3 border-l-4 transition hover:bg-gray-50 {{ $isActive ? 'bg-purple-50 border-purple-500' : 'border-transparent' }}">
                    <svg class="w-4 h-4 {{ $isActive ? 'text-purple-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-sm {{ $isActive ? 'font-medium text-purple-700' : 'text-gray-600' }}">{{ $quizItem->title }}</span>
                </a>
            @endforeach
        @endforeach
    </div>
</aside>
