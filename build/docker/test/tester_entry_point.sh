#!/bin/bash
whoami

echo "Test-Cat: registration_module"
echo "Project: j502_bwpm427"

sudo chmod 1777 /tmp/.X11-unix
sudo rm -f /tmp/.X45-lock
sudo mkdir -p /home/seluser/.local/share/mc
sudo chown -R seluser:users /home/seluser

export BW_TEST_WITHDRAW="no"
VIDEO_NAME=/data/output/videos/registration_module.mp4
VIDEO_LOG=/data/output/logs/ffmpeg.log

DISPLAY=":45"

# start x-server and webdriver for chromium
/usr/bin/Xvfb :45 -ac -screen 0 1920x1080x16 &
export DISPLAY=${DISPLAY}

echo "Video-Name: ${VIDEO_NAME}"
echo "Display: ${DISPLAY}"
echo "Withdraw: ${BW_TEST_WITHDRAW}"

java -jar /opt/selenium/selenium-server.jar standalone --port 4445 >/data/output/logs/selenium.log 2>/data/output/logs/selenium.log &

# Loop until selenium server is available
printf 'Waiting Selenium Server to load\n'
sleep 15

printf '\n'

sudo chmod 0777 /data/output/logs/selenium.log

# start video recording
echo 'start recording'
tmux new-session -d -s BwPostmanRecording1 "ffmpeg -y -f x11grab -draw_mouse 0 -video_size 1920x1080 -i :45.0 -vcodec libx264 -r 12 ${VIDEO_NAME} 2>${VIDEO_LOG}"

# run tests
tests/job_scripts/bwpm_test_runner.sh

# stop video recording
echo 'stop recording'
sleep 1
tmux send-keys -t BwPostmanRecording1 q
sleep 3
XVFB_PID="$(pgrep -f /usr/bin/Xvfb)"
echo "PID: ${XVFB_PID}"
kill "$(pgrep -f /usr/bin/Xvfb)"

# sleep 120
