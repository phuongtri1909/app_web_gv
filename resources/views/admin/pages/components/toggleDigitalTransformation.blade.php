<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.digital-transformation-switch').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const newsId = this.getAttribute('data-news-id');
                const isChecked = this.checked;

                fetch('{{ route('news.toggleDigitalTransformation') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            news_id: newsId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message, 'success');
                            if (data.status === 'added') {
                                checkbox.checked = true;
                            } else if (data.status === 'removed') {
                                checkbox.checked = false;
                            }
                        } else {
                            showToast(data.message, 'error');
                            checkbox.checked = !isChecked;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Có lỗi xảy ra, vui lòng thử lại sau.', 'error');
                        checkbox.checked = !isChecked;
                    });
            });
        });
    });
</script>