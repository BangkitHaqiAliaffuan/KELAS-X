import React from 'react';

const Tabel = ({ headers, data, onAction }) => {
  return (
    <div className="table-responsive">
      <table className="table table-striped table-hover">
        <thead className="table-dark">
          <tr>
            {headers.map((header, index) => (
              <th key={index} scope="col">{header.label}</th>
            ))}
            {onAction && <th scope="col">Aksi</th>}
          </tr>
        </thead>
        <tbody>
          {data.map((item, rowIndex) => (
            <tr key={rowIndex}>
              {headers.map((header, colIndex) => (
                <td key={colIndex}>
                  {header.format 
                    ? header.format(item[header.key])
                    : item[header.key]}
                </td>
              ))}
              {onAction && (
                <td>
                  <button 
                    className="btn btn-primary btn-sm"
                    onClick={() => onAction(item)}
                  >
                    Detail
                  </button>
                </td>
              )}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Tabel;