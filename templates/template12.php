<?php
// Engineering Elite Template (Premium)
?>
<div class="cv-template engineering-template">
    <div class="engineering-header">
        <div class="code-background">
            <div class="code-pattern">
                <span>&lt;/&gt;</span>
                <span>{ }</span>
                <span>&lt;div&gt;</span>
                <span>function()</span>
                <span>&lt;/&gt;</span>
            </div>
        </div>
        <div class="profile-section">
            <h1><?php echo htmlspecialchars($cvData['personal_info']['full_name'] ?? 'Your Name'); ?></h1>
            <div class="engineering-title"><?php echo htmlspecialchars($cvData['personal_info']['job_title'] ?? 'Software Engineer'); ?></div>
            <div class="engineering-bio"><?php echo htmlspecialchars($cvData['personal_info']['summary'] ?? 'Building scalable solutions with clean, efficient code'); ?></div>
            <div class="contact-bar">
                <span><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($cvData['personal_info']['email'] ?? ''); ?></span>
                <span><i class="fas fa-phone"></i> <?php echo htmlspecialchars($cvData['personal_info']['phone'] ?? ''); ?></span>
                <span><i class="fab fa-github"></i> <?php echo htmlspecialchars($cvData['personal_info']['website'] ?? ''); ?></span>
                <?php if (!empty($cvData['personal_info']['linkedin'])): ?>
                <span><i class="fab fa-linkedin"></i> <a href="<?php echo htmlspecialchars($cvData['personal_info']['linkedin']); ?>" target="_blank">LinkedIn</a></span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="engineering-content">
        <div class="projects-section">
            <?php if (!empty($cvData['work_experience'])): ?>
                <section class="cv-section">
                    <h2><i class="fas fa-code"></i> Development Projects</h2>
                    <?php foreach ($cvData['work_experience'] as $exp): ?>
                        <div class="project-block">
                            <div class="project-header">
                                <h3><?php echo htmlspecialchars($exp['job_title']); ?></h3>
                                <div class="tech-stack">
                                    <span class="tech-badge">React</span>
                                    <span class="tech-badge">Node.js</span>
                                    <span class="tech-badge">Python</span>
                                </div>
                            </div>
                            <div class="project-company"><?php echo htmlspecialchars($exp['company']); ?></div>
                            <div class="project-timeline">
                                <?php echo formatDate($exp['start_date']); ?> - <?php echo $exp['current'] ? 'Present' : formatDate($exp['end_date']); ?>
                                <?php if (!empty($exp['location'])): ?> • <?php echo htmlspecialchars($exp['location']); ?><?php endif; ?>
                            </div>
                            <?php if (!empty($exp['description'])): ?>
                                <div class="project-description">
                                    <p><?php echo nl2br(htmlspecialchars($exp['description'])); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>

            <?php if (!empty($cvData['education'])): ?>
                <section class="cv-section">
                    <h2><i class="fas fa-graduation-cap"></i> Technical Education</h2>
                    <div class="education-blocks">
                        <?php foreach ($cvData['education'] as $edu): ?>
                            <div class="education-block">
                                <div class="degree-icon"><i class="fas fa-certificate"></i></div>
                                <div class="degree-info">
                                    <h4><?php echo htmlspecialchars($edu['degree']); ?></h4>
                                    <div class="school"><?php echo htmlspecialchars($edu['school']); ?></div>
                                    <div class="year"><?php echo formatDate($edu['graduation_date']); ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </div>

        <div class="tech-sidebar">
            <?php if (!empty($cvData['skills'])): ?>
                <div class="skills-card">
                    <h3>Technical Skills</h3>
                    <div class="skills-categories">
                        <div class="skill-category">
                            <h4>Languages</h4>
                            <div class="skill-tags">
                                <?php
                                $languages = array_filter($cvData['skills'], function($skill) {
                                    return in_array(strtolower($skill['name']), ['javascript', 'python', 'java', 'c++', 'php', 'ruby', 'go', 'rust', 'typescript']);
                                });
                                foreach ($languages as $skill): ?>
                                    <span class="skill-tag <?php echo strtolower($skill['level']); ?>"><?php echo htmlspecialchars($skill['name']); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="skill-category">
                            <h4>Frameworks & Tools</h4>
                            <div class="skill-tags">
                                <?php
                                $frameworks = array_filter($cvData['skills'], function($skill) {
                                    return !in_array(strtolower($skill['name']), ['javascript', 'python', 'java', 'c++', 'php', 'ruby', 'go', 'rust', 'typescript']);
                                });
                                foreach ($frameworks as $skill): ?>
                                    <span class="skill-tag <?php echo strtolower($skill['level']); ?>"><?php echo htmlspecialchars($skill['name']); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($cvData['certifications'])): ?>
                <div class="certifications-card">
                    <h3>Certifications</h3>
                    <div class="cert-list">
                        <?php foreach ($cvData['certifications'] as $cert): ?>
                            <li><?php echo htmlspecialchars($cert['name']); ?> - <?php echo htmlspecialchars($cert['issuer']); ?></li>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($cvData['languages'])): ?>
                <div class="languages-card">
                    <h3>Spoken Languages</h3>
                    <div class="language-proficiency">
                        <?php foreach ($cvData['languages'] as $lang): ?>
                            <div class="language-bar">
                                <div class="lang-name"><?php echo htmlspecialchars($lang['name']); ?></div>
                                <div class="proficiency-bar">
                                    <div class="bar-fill" style="width: <?php echo getProficiencyPercentage($lang['proficiency']); ?>%"></div>
                                </div>
                                <div class="proficiency-level"><?php echo htmlspecialchars($lang['proficiency']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.engineering-template { font-family: 'Fira Code', 'Monaco', 'Consolas', monospace; background: #f8f9fa; }
.engineering-header { background: linear-gradient(135deg, #2d3748, #1a202c); color: white; padding: 50px 30px; position: relative; overflow: hidden; }
.code-background { position: absolute; top: 0; right: 0; width: 40%; height: 100%; opacity: 0.1; }
.code-pattern { display: flex; flex-direction: column; gap: 20px; font-size: 2em; height: 100%; justify-content: center; align-items: center; }
.code-pattern span { opacity: 0.6; }
.profile-section { position: relative; z-index: 1; max-width: 60%; }
.profile-section h1 { margin: 0; font-size: 2.5em; font-weight: 600; }
.engineering-title { font-size: 1.2em; margin: 10px 0; opacity: 0.9; }
.engineering-bio { font-size: 1em; margin: 15px 0; line-height: 1.5; max-width: 500px; opacity: 0.8; }
.contact-bar { display: flex; gap: 30px; margin-top: 20px; font-size: 0.9em; }
.contact-bar span { display: flex; align-items: center; gap: 8px; }
.contact-bar i { opacity: 0.7; }
.engineering-content { display: grid; grid-template-columns: 2fr 1fr; gap: 40px; padding: 40px 30px; }
.cv-section h2 { color: #2d3748; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }
.cv-section h2 i { color: #3182ce; }
.project-block { background: white; border-radius: 8px; padding: 25px; margin-bottom: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-left: 4px solid #3182ce; }
.project-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
.project-header h3 { margin: 0; color: #2d3748; font-size: 1.1em; }
.tech-stack { display: flex; gap: 8px; }
.tech-badge { background: #e2e8f0; color: #3182ce; padding: 4px 8px; border-radius: 12px; font-size: 0.75em; font-weight: 500; }
.project-company { color: #3182ce; font-weight: 600; margin-bottom: 5px; }
.project-timeline { color: #718096; font-size: 0.9em; margin-bottom: 15px; }
.project-description p { color: #4a5568; line-height: 1.6; }
.education-blocks { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
.education-block { background: white; border-radius: 8px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 15px; }
.degree-icon { font-size: 2em; color: #3182ce; }
.degree-info h4 { margin: 0 0 3px 0; color: #2d3748; }
.school { color: #3182ce; font-weight: 500; }
.year { color: #718096; font-size: 0.9em; }
.skills-card, .certifications-card, .languages-card { background: white; border-radius: 8px; padding: 25px; margin-bottom: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
.skills-card h3, .certifications-card h3, .languages-card h3 { margin: 0 0 20px 0; color: #2d3748; font-size: 1.2em; }
.skill-category { margin-bottom: 20px; }
.skill-category h4 { margin: 0 0 10px 0; color: #4a5568; font-size: 1em; }
.skill-tags { display: flex; flex-wrap: wrap; gap: 8px; }
.skill-tag { background: #edf2f7; color: #2d3748; padding: 6px 12px; border-radius: 16px; font-size: 0.8em; font-weight: 500; }
.skill-tag.expert { background: #3182ce; color: white; }
.skill-tag.advanced { background: #2b6cb0; color: white; }
.skill-tag.intermediate { background: #4299e1; color: white; }
.cert-list { padding: 0; margin: 0; list-style: none; }
.cert-list li { padding: 8px 0; border-bottom: 1px solid #e2e8f0; color: #4a5568; }
.language-proficiency { display: flex; flex-direction: column; gap: 15px; }
.language-bar { display: flex; align-items: center; gap: 15px; }
.lang-name { min-width: 80px; font-weight: 500; color: #2d3748; }
.proficiency-bar { flex: 1; height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden; }
.bar-fill { height: 100%; background: linear-gradient(45deg, #3182ce, #2c5282); border-radius: 3px; }
.proficiency-level { min-width: 100px; text-align: right; color: #718096; font-size: 0.9em; }
</style>