import requests
import sqlite3
import config as cfg
r = requests.session()

f = open('ClimbData.csv', 'wb')
f.write('TeamNum, NoClimb, Level1, Level2, Level3\n')
climbs = dict()
headers = {'X-TBA-Auth-Key': cfg.TBA_AUTH_KEY}
tba  = r.get("https://www.thebluealliance.com/api/v3/event/2019ilpe/matches", headers = headers)
tbAnswer = tba.json()
for match in tbAnswer:
    try:
        matchNum = match['match_number']
        blueTeams = match['alliances']['blue']['team_keys']
        redTeams = match['alliances']['red']['team_keys']
        b1 = blueTeams[0][3:]
        b2 = blueTeams[1][3:]
        b3 = blueTeams[2][3:]
        r1 = redTeams[0][3:]
        r2 = redTeams[1][3:]
        r3 = redTeams[2][3:]
        #print(str(matchNum)+':'+b1+','+b2+','+b3+','+r1+','+r2+','+r3+'\n')

        b1Climb = match['score_breakdown']['blue']['endgameRobot1']
        b2Climb = match['score_breakdown']['blue']['endgameRobot2']
        b3Climb = match['score_breakdown']['blue']['endgameRobot3']
        r1Climb = match['score_breakdown']['red']['endgameRobot1']
        r2Climb = match['score_breakdown']['red']['endgameRobot2']
        r3Climb = match['score_breakdown']['red']['endgameRobot3']

        teams = [b1, b2, b3, r1, r2, r3]
        teamClimbs = [b1Climb, b2Climb, b3Climb, r1Climb, r2Climb, r3Climb]
        for i in range(0,6):
            if not climbs.has_key(teams[i]):
                climbs[teams[i]] = [0, 0, 0, 0]
            if teamClimbs[i] == 'None':
                climbs[teams[i]][0] += 1
            elif teamClimbs[i] == 'HabLevel1':
                climbs[teams[i]][1] += 1
            elif teamClimbs[i] == 'HabLevel2':
                climbs[teams[i]][2] += 1
            elif teamClimbs[i] == 'HabLevel3':
                climbs[teams[i]][3] += 1
    except:
        continue


for team in climbs.keys():
    insertStr = "{0},{1},{2},{3},{4}\n".format(team, climbs[team][0], climbs[team][1], climbs[team][2], climbs[team][3])
    f.write(insertStr)
        
f.close()
