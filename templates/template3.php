<?php
// Creative Template
// $cvData is available from the including script
?>
<div class="cv-template creative-template">
    <header class="cv-header creative-header">
        <div class="personal-info">
            <h1><?php echo htmlspecialchars($cvData['personal_info']['full_name'] ?? 'Your Name'); ?></h1>
            <?php if (!empty($cvData['personal_info']['job_title'])): ?>
                <h2><?php echo htmlspecialchars($cvData['personal_info']['job_title']); ?></h2>
            <?php endif; ?>
            <?php if (!empty($cvData['personal_info']['summary'])): ?>
                <p class="summary"><?php echo htmlspecialchars($cvData['personal_info']['summary']); ?></p>
            <?php endif; ?>
        </div>
    </header>

    <div class="creative-body">
        <aside class="creative-sidebar">
            <section class="cv-section contact-section">
                <h3 class="sidebar-title">Contact</h3>
                <div class="contact-info">
                    <?php if (!empty($cvData['personal_info']['email'])): ?>
                        <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($cvData['personal_info']['email']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($cvData['personal_info']['phone'])): ?>
                        <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($cvData['personal_info']['phone']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($cvData['personal_info']['address'])): ?>
                         <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($cvData['personal_info']['address']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($cvData['personal_info']['website'])): ?>
                        <p><i class="fas fa-globe"></i> <a href="<?php echo htmlspecialchars($cvData['personal_info']['website']); ?>" target="_blank">Portfolio</a></p>
                    <?php endif; ?>
                    <?php if (!empty($cvData['personal_info']['linkedin'])): ?>
                        <p><i class="fab fa-linkedin"></i> <a href="<?php echo htmlspecialchars($cvData['personal_info']['linkedin']); ?>" target="_blank">LinkedIn</a></p>
                    <?php endif; ?>
                </div>
            </section>

            <?php if (!empty($cvData['skills'])): ?>
                <section class="cv-section skills-section">
                    <h3 class="sidebar-title">Skills</h3>
                    <div class="skills-list">
                        <?php foreach ($cvData['skills'] as $skill): ?>
                            <div class="skill-item">
                                <span class="skill-name"><?php echo htmlspecialchars($skill['name']); ?></span>
                                <span class="skill-level"><?php echo htmlspecialchars($skill['level']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (!empty($cvData['education'])): ?>
                <section class="cv-section education-section">
                    <h3 class="sidebar-title">Education</h3>
                    <?php foreach ($cvData['education'] as $edu): ?>
                        <div class="education-item">
                            <h4><?php echo htmlspecialchars($edu['degree']); ?></h4>
                            <p><?php echo htmlspecialchars($edu['school']); ?></p>
                            <p class="dates"><?php echo formatDate($edu['graduation_date']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>
        </aside>

        <main class="creative-main-content">
            <?php if (!empty($cvData['work_experience'])): ?>
                <section class="cv-section experience-section">
                    <h2 class="main-title"><i class="fas fa-briefcase"></i> Work Experience</h2>
                    <?php foreach ($cvData['work_experience'] as $exp): ?>
                        <div class="work-item">
                            <div class="work-header">
                                <h3><?php echo htmlspecialchars($exp['job_title']); ?></h3>
                                <h4><?php echo htmlspecialchars($exp['company']); ?></h4>
                            </div>
                            <div class="work-details">
                                <span class="dates"><i class="fas fa-calendar-alt"></i> <?php echo formatDate($exp['start_date']); ?> - <?php echo $exp['current'] ? 'Present' : formatDate($exp['end_date']); ?></span>
                                <?php if (!empty($exp['location'])): ?>
                                    <span class="location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($exp['location']); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($exp['description'])): ?>
                                <ul class="description-list">
                                    <?php 
                                    $description_points = explode("\n", $exp['description']);
                                    foreach ($description_points as $point) {
                                        if (!empty(trim($point))) {
                                            echo '<li>' . htmlspecialchars(trim($point)) . '</li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>
        </main>
    </div>
</div>
