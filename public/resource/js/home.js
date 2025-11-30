const text = "HI. I'm <span id='name'></span> ...";
const speed = 100;
let i = 0;

function typewriter() {
  if (i < text.length) {
    let currentChar = text.charAt(i);

    if (currentChar === "<") {
      let tag = "";
      while (i < text.length && text.charAt(i) !== ">") {
        tag += text.charAt(i);
        i++;
      }
      if (i < text.length) {
        tag += ">";
        i++;
      }

      document.getElementById("autotext1").innerHTML += tag;
      document.getElementById("name").textContent = "NAMERAID";
    } else {
      document.getElementById("autotext1").innerHTML += currentChar;
      i++;
    }

    setTimeout(typewriter, speed);
  }
}

// Start the typewriter effect when the page loads
window.addEventListener('DOMContentLoaded', () => {
  typewriter();
  typing();
  tampilkanrole();
});
const targetText = "Welcome To My Space";
const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()";
const element = document.getElementById("text");

let iteration = 0;
function typing() {
  const interval = setInterval(() => {
    let displayText = "";

    for (let i = 0; i < targetText.length; i++) {
      if (i < iteration) {
        displayText += targetText[i];
      } else if (targetText[i] === " ") {
        displayText += " ";
      } else {
        displayText += characters[Math.floor(Math.random() * characters.length)];
      }
    }

    element.innerText = displayText;


    if (iteration <= targetText.length) {
      iteration++;
    } else {
      clearInterval(interval);
      element.classList.add("selesai");

    }

  }, 300);
}
let roles = [];

let roleIndex = 0;
let charIndex = 0;
let typingSpeed = 100;
let deletingSpeed = 50;
let isDeleting = false;

function typeLoop() {
  const currentRole = roles[roleIndex];
  const display = document.getElementById("roleText");

  if (!currentRole) return; // jika role kosong, hentikan

  if (isDeleting) {
    charIndex--;
    display.textContent = currentRole.substring(0, charIndex--);
  } else {
    charIndex++;
    display.textContent = currentRole.substring(0, charIndex++);
  }

  if (!isDeleting && charIndex >= currentRole.length) {
    isDeleting = true;
    setTimeout(typeLoop, 1000); // delay sebelum menghapus
    return;
  } else if (isDeleting && charIndex === 0) {
    isDeleting = false;
    roleIndex = (roleIndex + 1) % roles.length;
  }

  setTimeout(typeLoop, isDeleting ? deletingSpeed : typingSpeed);
}

// menampilkkan sebuah role 
function tampilkanrole() {
  const targetText = document.getElementById('roleText');
  const dataRole = ['BackEnd Developer', 'FrontEnd Developer', 'Cyber Security'];
  let index = 0;

  // Hapus interval sebelumnya jika sudah ada
  if (window.roleInterval) clearInterval(window.roleInterval);

  // Tampilkan role secara berulang setiap 2 detik
  window.roleInterval = setInterval(() => {
    targetText.textContent = dataRole[index];
    index = (index + 1) % dataRole.length;
  }, 5000);
}

window.addEventListener('scroll', function () {
  const navbar = document.getElementById('desktop-nav');
  const scrollTop = window.scrollY;
  const docHeight = document.body.scrollHeight - window.innerHeight;
  const scrollPercent = (scrollTop / docHeight) * 100;

  if (scrollPercent >= 30) {
    navbar.classList.add('scrolled');
    navbar.classList.remove('normal');
  } else {
    navbar.classList.remove('scrolled');
    navbar.classList.add('normal');
  }
});

fetch("/api/github")
  .then(async (api) => {
    let data;
    try {
      data = await api.json();
    } catch (jsonError) {
      throw new Error("Invalid JSON response from /api/github");
    }
    // Defensive: check for expected structure
    if (!data || !data.data || !data.data.viewer) {
      throw new Error("Unexpected API response structure");
    }
    const user = data.data.viewer;
    const username = user.login;
    const avatarUrl = user.avatarUrl;
    const bio = user.bio;
    const urlProfile = user.url;
    const repos = user.repositories.totalCount;
    const followers = user.followers.totalCount;
    const following = user.following.totalCount;
    const contributionData = user.contributionsCollection.contributionCalendar;

    document.getElementById('username').innerHTML = username;
    document.getElementById('bio').textContent = bio || 'No bio available';
    document.getElementById('repo').textContent = repos;
    document.getElementById('followers').textContent = followers;
    document.getElementById('following').textContent = following;
    document.getElementById('urlgit').href = urlProfile;
    document.getElementById('total-contributions').textContent = contributionData.totalContributions;

    const gitHubAvatar = document.querySelector('.kontainer-github img');
    if (gitHubAvatar) {
      gitHubAvatar.src = avatarUrl;
    }

    createContributionCalendar(contributionData);
  })
  .catch(error => {
    console.error("Error fetching GitHub data:", error);

    document.getElementById('username').textContent = 'Error loading profile';
    document.getElementById('bio').textContent = 'Could not load GitHub data. Please try again later.';
  });

function createContributionCalendar(contributionData) {
  let calendarContainer = document.getElementById('contribution-calendar');
  if (!calendarContainer) {
    calendarContainer = document.createElement('div');
    calendarContainer.id = 'contribution-calendar';
    calendarContainer.className = 'contribution-calendar';

    // Find a good place to insert the calendar
    const recentRepos = document.querySelector('.recent-repos');
    // The following variables are not defined in the original code:
    // calendarHeading, totalContributions
    // Remove these lines to avoid ReferenceError
    if (recentRepos && recentRepos.parentNode) {
      // recentRepos.parentNode.insertBefore(calendarHeading, recentRepos);
      // recentRepos.parentNode.insertBefore(totalContributions, recentRepos);
      recentRepos.parentNode.insertBefore(calendarContainer, recentRepos);
    }
  }

  // Clear existing calendar
  calendarContainer.innerHTML = '';

  // Create the calendar grid
  const calendarGrid = document.createElement('div');
  calendarGrid.className = 'calendar-grid';

  const monthLabels = document.createElement('div');
  monthLabels.className = 'month-labels';
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

  const weeks = contributionData.weeks;
  const totalWeeks = weeks.length;
  const weeksPerMonth = totalWeeks / 12;

  months.forEach((month, index) => {
    const monthLabel = document.createElement('div');
    monthLabel.className = 'month-label';
    monthLabel.textContent = month;
    monthLabel.style.left = `${(index * weeksPerMonth / totalWeeks) * 100}%`;
    monthLabels.appendChild(monthLabel);
  });

  calendarGrid.appendChild(monthLabels);

  const dayLabels = document.createElement('div');
  dayLabels.className = 'day-labels';
  const days = ['Mon', 'Wed', 'Fri'];

  days.forEach((day, index) => {
    const dayLabel = document.createElement('div');
    dayLabel.className = 'day-label';
    dayLabel.textContent = day;
    dayLabel.style.top = `${(index * 2 + 1) * 20}px`;
    dayLabels.appendChild(dayLabel);
  });

  calendarGrid.appendChild(dayLabels);

  const cellsContainer = document.createElement('div');
  cellsContainer.className = 'contribution-cells';

  weeks.forEach(week => {
    const weekElem = document.createElement('div');
    weekElem.className = 'contribution-week';

    week.contributionDays.forEach(day => {
      const cell = document.createElement('div');
      cell.className = 'contribution-cell';

      const colorMap = {
        '#ebedf0': '#181717',
        '#9be9a8': '#0e4429',
        '#40c463': '#006d32',
        '#30a14e': '#26a641',
        '#216e39': '#39d353'
      };

      cell.style.backgroundColor = colorMap[day.color] || day.color;

      const date = new Date(day.date);
      const formattedDate = date.toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });

      cell.setAttribute('data-date', formattedDate);
      cell.setAttribute('data-count', day.contributionCount);
      cell.setAttribute('title', `${day.contributionCount} contributions on ${formattedDate}`);

      // Add hover effect and tooltip
      cell.addEventListener('mouseover', function (e) {
        const tooltip = document.createElement('div');
        tooltip.className = 'contribution-tooltip';
        tooltip.style.backgroundColor = '#2d333b';
        tooltip.style.color = '#ffffff';
        tooltip.style.border = '1px solid #444c56';
        tooltip.innerHTML = `
          <strong>${this.getAttribute('data-count')} contributions</strong>
          <span>${this.getAttribute('data-date')}</span>
        `;

        document.body.appendChild(tooltip);

        const rect = this.getBoundingClientRect();
        tooltip.style.left = `${rect.left + window.scrollX}px`;
        tooltip.style.top = `${rect.top + window.scrollY - tooltip.offsetHeight - 10}px`;

        this.addEventListener('mouseout', function () {
          document.body.removeChild(tooltip);
        }, { once: true });
      });

      weekElem.appendChild(cell);
    });

    cellsContainer.appendChild(weekElem);
  });

  calendarGrid.appendChild(cellsContainer);
  calendarContainer.appendChild(calendarGrid);
}
