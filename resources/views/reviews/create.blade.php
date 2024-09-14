<x-app-layout>

  <div class="max-w-2xl mx-auto p-4">
    <h1
      class="text-center text-3xl font-medium text-gray-600 mt-10">
      Leave a Review
    </h1>
    <form action="{{ route('reviews.store') }}"
      method="POST">
      @csrf
      <input type="hidden" name="reviewee_id"
        value="{{ $revieweeId }}">
      <div class="mb-4">
        <label class="block text-gray-700">Rating</label>
        <input type="number" name="rating" min="1" max="5"
          class="w-full border rounded p-2" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700">Review</label>
        <textarea name="comment" rows="4"
          class="w-full border rounded p-2"
          required></textarea>
      </div>
      <button type="submit"
        class="bg-blue-500 text-white py-2 px-4 rounded">Submit
        Review</button>
    </form>
  </div>

</x-app-layout>