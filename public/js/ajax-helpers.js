function getProgramsOptions(levelId, assignedOnly = false) {
  if (!levelId) {
    return DEFAULT_SELECT;
  }

  return new Promise((resolve) => {
    $.get(
      `/getPrograms/${levelId}`,
      {
        assignedOnly: assignedOnly,
      },
      function (response) {
        const data = JSON.parse(response);
        let optionsHtml = DEFAULT_SELECT;
        data.forEach(function (d) {
          optionsHtml += `<option value="${d.id}" data-type="${d.type}">${d.name}</option>`;
        });
        resolve(optionsHtml);
      }
    );
  });
}

function getYearSemesterOptions(programId, assignedOnly = false) {
  if (!programId) {
    return DEFAULT_SELECT;
  }

  return new Promise((resolve) => {
    $.get(
      `/year-semester/${programId}`,
      {
        assignedOnly: assignedOnly,
      },
      function (response) {
        const data = JSON.parse(response);
        let optionsHtml = DEFAULT_SELECT;
        data.forEach(function (d) {
          optionsHtml += `<option value="${d.id}">${d.name}</option>`;
        });
        resolve(optionsHtml);
      }
    );
  });
}

function getYearSemestersByProgramAndBatch(programId, batchId, options = {}) {
  if (!programId || !batchId) {
    return [];
  }

  const { assignedOnly, withSections, all } = options;

  return new Promise((resolve) => {
    $.get(
      `/year-semester/${programId}/${batchId}`,
      {
        assignedOnly: !!assignedOnly,
        withSections: !!withSections,
        all: !!all,
      },
      function (response) {
        const data = JSON.parse(response);
        resolve(data);
      }
    );
  });
}

function getYearSemesterOptionsByProgramAndBatch(programId, batchId, options = {}) {
  if (!programId || !batchId) {
    return DEFAULT_SELECT;
  }

  const { assignedOnly } = options;

  return new Promise((resolve) => {
    $.get(
      `/year-semester/${programId}/${batchId}`,
      {
        assignedOnly: !!assignedOnly,
      },
      function (response) {
        const data = JSON.parse(response);
        let optionsHtml = DEFAULT_SELECT;
        data.forEach(function (d) {
          optionsHtml += `<option value="${d.id}">${d.name}</option>`;
        });
        resolve(optionsHtml);
      }
    );
  });
}

function getProgramYearSemesterOptions(programId, options = {}) {
  const hasBatchOrAcademicYearSelected = options.academicYearId || options.batchId;
  if (!programId || !hasBatchOrAcademicYearSelected) {
    return DEFAULT_SELECT;
  }

  const { assignedOnly } = options;

  return new Promise((resolve) => {
    $.get(
      `/yearSemester/${programId}`,
      {
        academicYearId: options.academicYearId,
        batchId: options.batchId,
        assignedOnly: !!assignedOnly,
      },
      function (response) {
        const data = JSON.parse(response);
        let optionsHtml = DEFAULT_SELECT;
        data.forEach(function (d) {
          optionsHtml += `<option value="${d.id}">${d.name}</option>`;
        });
        resolve(optionsHtml);
      }
    );
  });
}

function getSectionOptions(yearSemesterId, assignedOnly = false) {
  if (!yearSemesterId) {
    return DEFAULT_SELECT;
  }

  return new Promise((resolve) => {
    $.get(
      `/getSections/${yearSemesterId}`,
      {
        assignedOnly: assignedOnly,
      },
      function (response) {
        const data = JSON.parse(response);
        let optionsHtml = DEFAULT_SELECT;
        data.forEach(function (d) {
          optionsHtml += `<option value="${d.id}">${d.group_name}</option>`;
        });
        resolve(optionsHtml);
      }
    );
  });
}

function getExamOptionsByYearSemesterId(yearSemesterId) {
  if (!yearSemesterId) {
    return DEFAULT_SELECT;
  }

  return new Promise((resolve) => {
    $.get(`/getExamsByYearSemesterId/${yearSemesterId}`, function (response) {
      const data = JSON.parse(response);
      let optionsHtml = DEFAULT_SELECT;
      data.forEach(function (d) {
        optionsHtml += `<option value="${d.id}">${d.name}</option>`;
      });
      resolve(optionsHtml);
    });
  });
}

function getSectionOptionsByYearSemesterId(yearSemesterId) {
  if (!yearSemesterId) {
    return DEFAULT_SELECT;
  }

  return new Promise((resolve) => {
    $.get(`/getSectionsByYearSemesterId/${yearSemesterId}`, function (response) {
      const data = JSON.parse(response);
      let optionsHtml = DEFAULT_SELECT;
      data.forEach(function (d) {
        optionsHtml += `<option value="${d.id}">${d.group_name}</option>`;
      });
      resolve(optionsHtml);
    });
  });
}

function getExamStudentOptions(examId) {
  if (!examId) {
    return ALL_SELECT;
  }

  return new Promise((resolve) => {
    $.get(`/getExamStudents/${examId}`, function (response) {
      const data = JSON.parse(response);
      let optionsHtml = ALL_SELECT;
      data.forEach(function (d) {
        optionsHtml += `<option value="${d.id}">${d.sname}</option>`;
      });
      resolve(optionsHtml);
    });
  });
}

function getSubjectOptions(yearSemesterId) {
  if (!yearSemesterId) {
    return DEFAULT_SELECT;
  }

  return new Promise((resolve) => {
    $.get(`/getSubjects/${yearSemesterId}`, function (response) {
      const data = JSON.parse(response);
      let optionsHtml = DEFAULT_SELECT;
      data.forEach(function (d) {
        optionsHtml += `<option value="${d.id}">${d.name}</option>`;
      });
      resolve(optionsHtml);
    });
  });
}

function getTeacherOptions(subjectId) {
  if (!subjectId) {
    return DEFAULT_SELECT;
  }

  return new Promise((resolve) => {
    $.get(`/getTeachers/${subjectId}`, function (response) {
      const data = JSON.parse(response);
      let optionsHtml = DEFAULT_SELECT;
      data.forEach(function (d) {
        optionsHtml += `<option value="${d.id}">${d.name}</option>`;
      });
      resolve(optionsHtml);
    });
  });
}

// function getBatchByAcademicYearId(academicYearId) {
//   if (!academicYearId) {
//     return DEFAULT_SELECT;
//   }

//   return new Promise((resolve) => {
//     $.get(`/academic-year/${academicYearId}/batch`, function (response) {
//       const data = JSON.parse(response);
//       let optionsHtml = DEFAULT_SELECT;
//       data.forEach(function (d) {
//         optionsHtml += `<option value="${d.id}">${d.title}</option>`;
//       });
//       resolve(optionsHtml);
//     });
//   });
// }

// function generateOptions(data, defaultValue = '') {
//   let optionsHtml = DEFAULT_SELECT;
//   data.forEach(function (d) {
//     optionsHtml += `<option value="${d.id}">${d.name}</option>`;
//   });
//   return optionsHtml;
// }
