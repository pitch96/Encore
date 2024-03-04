//
//  UpdateEventChargeModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 28/04/23.
//

import Foundation
// MARK: - Create structure for get Event Charge
struct EventChargeModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: eventChargeModelDetail?
}

// MARK: - DataClass
struct eventChargeModelDetail: Codable {
    var id: Int?, charge: Int?
    var createdAt, updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id, charge
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}
// MARK: - Create structure for Update Event Charge
struct UpdateEventChargeModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: UpdateChargeDetails?
}

// MARK: - DataClass
struct UpdateChargeDetails: Codable {
    var id: Int?
    var charge, createdAt, updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id, charge
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}
