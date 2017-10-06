select s.emp_no, salary, to_date
from salaries s
join
(select s.emp_no from 
salaries as s 
join employees as 
    e on s.emp_no = e.emp_no 
group by s.emp_no) as top_emp
on s.emp_no = top_emp.emp_no
where s.to_date = '9999-01-01'
order by s.salary desc limit 5;