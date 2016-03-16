import sched, time
import os
from subprocess import call

s = sched.scheduler(time.time, time.sleep)
def do_something(sc): 
    print ("Doing stuff...")

    os.system("php /Applications/XAMPP/xamppfiles/htdocs/Queue/artisan queue:listen")
    # do your stuff
    sc.enter(2, 1, do_something, (sc,))

s.enter(2, 1, do_something, (s,))
s.run()
