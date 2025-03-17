// Lesson related JavaScript functionality

document.addEventListener('DOMContentLoaded', function() {
    // Code editor functionality
    const codeEditors = document.querySelectorAll('.code-editor');
    const editors = [];
    
    if (codeEditors.length > 0) {
        codeEditors.forEach((editorElement, index) => {
            // Initialize code editor (using CodeMirror or similar library)
            const editor = CodeMirror.fromTextArea(editorElement, {
                lineNumbers: true,
                mode: editorElement.dataset.language || 'javascript',
                theme: 'monokai',
                indentUnit: 4,
                autoCloseBrackets: true,
                matchBrackets: true,
                lineWrapping: true
            });
            
            editors.push(editor);
            
            // Run code button
            const runButton = document.querySelector(`#runCode${index + 1}`);
            if (runButton) {
                runButton.addEventListener('click', function() {
                    const code = editor.getValue();
                    const outputElement = document.querySelector(`#codeOutput${index + 1}`);
                    
                    if (outputElement) {
                        try {
                            // For JavaScript code, we can evaluate it
                            if (editorElement.dataset.language === 'javascript') {
                                // Create a sandbox for evaluation
                                const sandbox = document.createElement('iframe');
                                sandbox.style.display = 'none';
                                document.body.appendChild(sandbox);
                                
                                // Redirect console.log to our output
                                const originalConsoleLog = console.log;
                                let output = '';
                                
                                console.log = function() {
                                    const args = Array.from(arguments);
                                    output += args.join(' ') + '\n';
                                    originalConsoleLog.apply(console, arguments);
                                };
                                
                                // Evaluate the code
                                try {
                                    const result = sandbox.contentWindow.eval(code);
                                    if (result !== undefined) {
                                        output += '=> ' + result;
                                    }
                                    outputElement.innerHTML = `<pre>${output}</pre>`;
                                    outputElement.classList.remove('error');
                                } catch (error) {
                                    outputElement.innerHTML = `<pre class="text-danger">${error}</pre>`;
                                    outputElement.classList.add('error');
                                }
                                
                                // Restore console.log
                                console.log = originalConsoleLog;
                                
                                // Clean up
                                document.body.removeChild(sandbox);
                            } else {
                                // For other languages, we would need a backend service
                                // Here we'll just show a message
                                outputElement.innerHTML = `<pre>Kode ${editorElement.dataset.language} perlu dijalankan di server. Mengirim ke server...</pre>`;
                                
                                // Send code to server for execution
                                fetch(baseUrl + 'lessons/run_code', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: `code=${encodeURIComponent(code)}&language=${editorElement.dataset.language}`
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        outputElement.innerHTML = `<pre>${data.output}</pre>`;
                                        outputElement.classList.remove('error');
                                    } else {
                                        outputElement.innerHTML = `<pre class="text-danger">${data.error}</pre>`;
                                        outputElement.classList.add('error');
                                    }
                                })
                                .catch(error => {
                                    outputElement.innerHTML = `<pre class="text-danger">Error: ${error.message}</pre>`;
                                    outputElement.classList.add('error');
                                });
                            }
                        } catch (error) {
                            outputElement.innerHTML = `<pre class="text-danger">${error}</pre>`;
                            outputElement.classList.add('error');
                        }
                    }
                });
            }
            
            // Reset code button
            const resetButton = document.querySelector(`#resetCode${index + 1}`);
            if (resetButton) {
                const originalCode = editorElement.value;
                
                resetButton.addEventListener('click', function() {
                    editor.setValue(originalCode);
                    
                    const outputElement = document.querySelector(`#codeOutput${index + 1}`);
                    if (outputElement) {
                        outputElement.innerHTML = '';
                        outputElement.classList.remove('error');
                    }
                });
            }
        });
    }
    
    // Lesson navigation
    const prevLessonBtn = document.getElementById('prevLesson');
    const nextLessonBtn = document.getElementById('nextLesson');
    
    if (prevLessonBtn) {
        prevLessonBtn.addEventListener('click', function() {
            const prevLessonId = this.dataset.lessonId;
            const courseSlug = this.dataset.courseSlug;
            
            if (prevLessonId && courseSlug) {
                window.location.href = baseUrl + 'courses/' + courseSlug + '/lesson/' + prevLessonId;
            }
        });
    }
    
    if (nextLessonBtn) {
        nextLessonBtn.addEventListener('click', function() {
            const nextLessonId = this.dataset.lessonId;
            const courseSlug = this.dataset.courseSlug;
            
            if (nextLessonId && courseSlug) {
                window.location.href = baseUrl + 'courses/' + courseSlug + '/lesson/' + nextLessonId;
            }
        });
    }
    
    // Lesson completion
    const completeButton = document.getElementById('completeLesson');
    
    if (completeButton) {
        completeButton.addEventListener('click', function() {
            const lessonId = this.dataset.lessonId;
            const courseId = this.dataset.courseId;
            
            // Send AJAX request to mark lesson as completed
            fetch(baseUrl + 'lessons/complete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `lesson_id=${lessonId}&course_id=${courseId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI to show completion
                    this.textContent = 'Selesai ✓';
                    this.classList.remove('btn-primary');
                    this.classList.add('btn-success');
                    this.disabled = true;
                    
                    // Update progress in sidebar
                    const sidebarItem = document.querySelector(`.lesson-item[data-lesson-id="${lessonId}"]`);
                    if (sidebarItem) {
                        sidebarItem.classList.add('completed');
                        
                        // Update check icon
                        const checkIcon = sidebarItem.querySelector('.check-icon');
                        if (checkIcon) {
                            checkIcon.classList.remove('far', 'fa-circle');
                            checkIcon.classList.add('fas', 'fa-check-circle');
                        }
                    }
                    
                    // Show next lesson button if available
                    if (data.next_lesson_id) {
                        if (nextLessonBtn) {
                            nextLessonBtn.dataset.lessonId = data.next_lesson_id;
                            nextLessonBtn.style.display = 'inline-block';
                        }
                    } else {
                        // Show course completion message if this was the last lesson
                        const lessonContent = document.querySelector('.lesson-content');
                        if (lessonContent) {
                            const completionMessage = document.createElement('div');
                            completionMessage.className = 'alert alert-success mt-4';
                            completionMessage.innerHTML = '<strong>Selamat!</strong> Anda telah menyelesaikan semua pelajaran dalam kursus ini. <a href="' + baseUrl + 'dashboard" class="alert-link">Kembali ke Dashboard</a>';
                            lessonContent.appendChild(completionMessage);
                        }
                    }
                } else {
                    // Show error message
                    alert(data.message || 'Gagal menandai pelajaran sebagai selesai. Silakan coba lagi.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        });
    }
    
    // Quiz functionality
    const quizForm = document.getElementById('quizForm');
    
    if (quizForm) {
        quizForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const quizId = this.dataset.quizId;
            const lessonId = this.dataset.lessonId;
            const courseId = this.dataset.courseId;
            
            // Collect answers
            const answers = [];
            const questionElements = document.querySelectorAll('.quiz-question');
            
            questionElements.forEach(question => {
                const questionId = question.dataset.questionId;
                const questionType = question.dataset.questionType;
                let answer;
                
                if (questionType === 'multiple_choice') {
                    const selectedOption = question.querySelector('input[name="question_' + questionId + '"]:checked');
                    answer = selectedOption ? selectedOption.value : null;
                } else if (questionType === 'text') {
                    const textInput = question.querySelector('textarea[name="question_' + questionId + '"]');
                    answer = textInput ? textInput.value : null;
                }
                
                answers.push({
                    question_id: questionId,
                    answer: answer
                });
            });
            
            // Send answers to server
            fetch(baseUrl + 'lessons/submit_quiz', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    quiz_id: quizId,
                    lesson_id: lessonId,
                    course_id: courseId,
                    answers: answers
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show results
                    const resultElement = document.getElementById('quizResult');
                    if (resultElement) {
                        resultElement.innerHTML = `
                            <div class="alert alert-info">
                                <h4>Hasil Quiz</h4>
                                <p>Skor: ${data.score}%</p>
                                <p>Benar: ${data.correct_answers} dari ${data.total_questions}</p>
                            </div>
                        `;
                        
                        // Show feedback for each question
                        data.question_results.forEach(result => {
                            const questionElement = document.querySelector(`.quiz-question[data-question-id="${result.question_id}"]`);
                            if (questionElement) {
                                const feedbackElement = document.createElement('div');
                                feedbackElement.className = result.is_correct ? 'alert alert-success mt-2' : 'alert alert-danger mt-2';
                                feedbackElement.innerHTML = result.feedback;
                                questionElement.appendChild(feedbackElement);
                            }
                        });
                        
                        // If passed, enable complete lesson button
                        if (data.passed && completeButton) {
                            completeButton.disabled = false;
                            
                            const passMessage = document.createElement('div');
                            passMessage.className = 'alert alert-success mt-3';
                            passMessage.textContent = 'Selamat! Anda telah lulus quiz ini. Anda sekarang dapat menyelesaikan pelajaran.';
                            resultElement.appendChild(passMessage);
                        } else if (completeButton) {
                            const failMessage = document.createElement('div');
                            failMessage.className = 'alert alert-warning mt-3';
                            failMessage.textContent = 'Anda perlu mendapatkan skor minimal 70% untuk menyelesaikan pelajaran ini. Silakan coba lagi.';
                            resultElement.appendChild(failMessage);
                        }
                    }
                } else {
                    alert(data.message || 'Gagal mengirim jawaban quiz. Silakan coba lagi.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        });
    }
}); 